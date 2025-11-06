<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Services\AsaasPaymentService;
use App\Jobs\ReleaseReservedTickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $paymentRepo;
    protected $asaasService;

    public function __construct(
        PaymentRepositoryInterface $paymentRepo,
        AsaasPaymentService $asaasService
    ) {
        $this->paymentRepo = $paymentRepo;
        $this->asaasService = $asaasService;
    }

    public function show($orderId)
    {
        $order = $this->paymentRepo->findOrderById($orderId);
        return view('payment.show', compact('order'));
    }

    public function process($orderId, Request $request)
    {
        $order = $this->paymentRepo->findOrderById($orderId);
        
        $validationRules = ['payment_method' => 'required|in:credit_card,pix,boleto'];
        
        if ($request->payment_method === 'credit_card') {
            $validationRules = array_merge($validationRules, [
                'card_number' => 'required|string',
                'card_name' => 'required|string',
                'card_expiry' => 'required|string',
                'card_cvv' => 'required|string|size:3'
            ]);
        }
        
        $request->validate($validationRules);

        // Marcar ingressos como reservados
        foreach($order->orderItems as $item) {
            $item->ticket->update(['status' => 'Vendido']);
        }
        
        ReleaseReservedTickets::dispatch($order->order_id)->delay(now()->addMinutes(15));

        // Preparar dados do cartão se necessário
        $cardData = null;
        if ($request->payment_method === 'credit_card') {
            $cardData = [
                'card_number' => $request->card_number,
                'card_name' => $request->card_name,
                'card_expiry' => $request->card_expiry,
                'card_cvv' => $request->card_cvv
            ];
        }

        // Criar pagamento com split
        try {
            Log::info('=== INICIANDO PAGAMENTO ASAAS ===', [
                'order_id' => $order->order_id,
                'total_amount' => $order->total_amount,
                'payment_method' => $request->payment_method
            ]);
            
            $asaasResponse = $this->asaasService->createPaymentWithSplit(
                $order, 
                $request->payment_method, 
                $cardData
            );
            
            Log::info('=== PAGAMENTO CRIADO COM SUCESSO ===', [
                'payment_id' => $asaasResponse['id'] ?? null,
                'status' => $asaasResponse['status'] ?? null
            ]);
            
        } catch (\Exception $e) {
            foreach($order->orderItems as $item) {
                $item->ticket->update(['status' => 'Disponível']);
            }
            
            Log::error('=== ERRO NO PAGAMENTO ASAAS ===', [
                'error' => $e->getMessage(),
                'order_id' => $order->order_id
            ]);
            
            return redirect()->back()->with('error', 'Erro no pagamento: ' . $e->getMessage());
        }

        // Salvar pagamento no banco
        $this->paymentRepo->createPayment([
            'order_id' => $order->order_id,
            'payment_method' => $request->payment_method,
            'status' => $asaasResponse['status'] === 'CONFIRMED' ? 'completed' : 'pending',
            'amount' => $order->total_amount,
            'payment_date' => now(),
            'external_id' => $asaasResponse['id']
        ]);

        // Verificar status do pagamento
        if ($asaasResponse['status'] === 'CONFIRMED') {
            // Pagamento aprovado imediatamente (cartão)
            $this->paymentRepo->updateOrderStatus($orderId, [
                'status' => 'concluído',
                'payment' => $request->payment_method
            ]);
            
            foreach($order->orderItems as $item) {
                $item->ticket->update(['status' => 'Vendido']);
            }
            
            Log::info('=== PAGAMENTO CONFIRMADO ===', ['order_id' => $order->order_id]);
            
            return view('payment.success', compact('order'));
        } else {
            // Pagamento pendente (PIX/Boleto)
            Log::info('=== PAGAMENTO PENDENTE ===', [
                'order_id' => $order->order_id,
                'status' => $asaasResponse['status']
            ]);
            
            // Se for PIX, buscar QR Code
            if ($request->payment_method === 'pix') {
                try {
                    $pixData = $this->asaasService->getPixQrCode($asaasResponse['id']);
                    $asaasResponse = array_merge($asaasResponse, $pixData);
                } catch (\Exception $e) {
                    Log::error('Erro ao buscar QR Code PIX', ['error' => $e->getMessage()]);
                }
            }
            
            return view('payment.pending', [
                'order' => $order,
                'paymentMethod' => $request->payment_method,
                'paymentData' => $asaasResponse
            ]);
        }
    }


    
    public function webhook(Request $request)
    {
        $payload = $request->all();
        
        Log::info('=== WEBHOOK ASAAS RECEBIDO ===', [
            'payload' => $payload,
            'headers' => $request->headers->all()
        ]);
        
        try {
            $paymentId = $payload['payment'] ?? null;
            $event = $payload['event'] ?? null;
            
            if (!$paymentId || !$event) {
                Log::warning('Webhook incompleto', ['payload' => $payload]);
                return response()->json(['status' => 'ignored']);
            }
            
            if (in_array($event, ['PAYMENT_CONFIRMED', 'PAYMENT_RECEIVED'])) {
                Log::info('=== PROCESSANDO CONFIRMAÇÃO DE PAGAMENTO ===', [
                    'event' => $event,
                    'payment_id' => $paymentId
                ]);
                
                $payment = $this->paymentRepo->findByExternalId($paymentId);
                
                if ($payment) {
                    Log::info('=== PAGAMENTO ENCONTRADO ===', [
                        'payment_id' => $payment->payment_id,
                        'order_id' => $payment->order_id,
                        'current_status' => $payment->status
                    ]);
                    
                    // Atualizar status do pagamento
                    $this->paymentRepo->updatePaymentStatus($payment->payment_id, 'completed');
                    
                    // Atualizar status do pedido
                    $this->paymentRepo->updateOrderStatus($payment->order_id, [
                        'status' => 'concluído',
                        'payment' => $payment->payment_method
                    ]);
                    
                    // Marcar ingressos como vendidos
                    $order = $this->paymentRepo->findOrderById($payment->order_id);
                    foreach($order->orderItems as $item) {
                        $item->ticket->update(['status' => 'Vendido']);
                    }
                    
                    Log::info('=== PAGAMENTO CONFIRMADO VIA WEBHOOK ===', [
                        'payment_id' => $paymentId,
                        'order_id' => $payment->order_id,
                        'new_order_status' => 'concluído'
                    ]);
                } else {
                    Log::warning('Pagamento não encontrado no banco', [
                        'payment_id' => $paymentId,
                        'searched_external_id' => $paymentId
                    ]);
                }
            } else {
                Log::info('=== EVENTO IGNORADO ===', [
                    'event' => $event,
                    'payment_id' => $paymentId
                ]);
            }
            
            return response()->json(['status' => 'ok']);
            
        } catch (\Exception $e) {
            Log::error('=== ERRO NO WEBHOOK ===', [
                'error' => $e->getMessage(),
                'payload' => $payload
            ]);
            
            return response()->json(['status' => 'error'], 500);
        }
    }
}