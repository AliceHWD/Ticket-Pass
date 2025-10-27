<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AsaasPaymentService
{
    // CONFIGURE AQUI OS WALLET IDs
    private const PLATFORM_WALLET_ID = 'wallet_empresa_001'; // Substitua pelo seu walletId da plataforma
    
    public function __construct()
    {
        if (!env('ASAAS_API_KEY')) {
            throw new \Exception('ASAAS_API_KEY não configurada no .env');
        }
    }
    
    public function createPaymentWithSplit($order, $paymentMethod, $cardData = null)
    {
        try {
            // 1. Criar cliente
            $customer = $this->createCustomer();
            if (!$customer || isset($customer['errors'])) {
                throw new \Exception('Erro ao criar cliente: ' . json_encode($customer['errors'] ?? []));
            }
            
            // 2. Calcular split
            $splitData = $this->calculateSplit($order);
            
            // 3. Preparar dados do pagamento
            $paymentData = [
                'customer' => $customer['id'],
                'billingType' => $this->getBillingType($paymentMethod),
                'value' => (float) $order->total_amount, // GARANTIR FLOAT
                'description' => 'Pedido #' . $order->order_number,
                'externalReference' => 'order_' . $order->order_id,
                'dueDate' => now()->addDays(1)->format('Y-m-d'),
                'split' => $splitData
            ];
            
            // 4. Adicionar dados específicos do método
            if ($paymentMethod === 'credit_card' && $cardData) {
                $paymentData['creditCard'] = [
                    'holderName' => $cardData['card_name'],
                    'number' => preg_replace('/\D/', '', $cardData['card_number']),
                    'expiryMonth' => substr($cardData['card_expiry'], 0, 2),
                    'expiryYear' => '20' . substr($cardData['card_expiry'], 3, 2),
                    'ccv' => $cardData['card_cvv']
                ];
                
                $paymentData['creditCardHolderInfo'] = [
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                    'cpfCnpj' => '11144477735', // CPF para testes
                    'postalCode' => '01310-100',
                    'addressNumber' => '123',
                    'phone' => '(11) 99999-9999'
                ];
            }
            
            // 5. Fazer requisição
            Log::info('=== ASAAS REQUEST ===', [
                'url' => env('ASAAS_BASE_URL') . '/payments',
                'data' => $paymentData,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'access_token' => 'HIDDEN (usando env direto)'
                ]
            ]);
            
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'access_token' => env('ASAAS_API_KEY'),
            ])->post(env('ASAAS_BASE_URL') . '/payments', $paymentData);
            
            // 6. Log completo da resposta
            Log::info('=== ASAAS RESPONSE ===', [
                'status' => $response->status(),
                'body' => $response->body(),
                'json' => $response->json(),
                'headers' => $response->headers()
            ]);
            
            // 7. Verificar resposta
            if (!$response->successful()) {
                Log::error('ASAAS HTTP ERROR', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                throw new \Exception('Erro HTTP ' . $response->status() . ': ' . $response->body());
            }
            
            $responseData = $response->json();
            
            if (isset($responseData['errors'])) {
                $errors = collect($responseData['errors'])->pluck('description')->implode(', ');
                Log::error('ASAAS API ERROR', ['errors' => $responseData['errors']]);
                throw new \Exception('Erro Asaas: ' . $errors);
            }
            
            return $responseData;
            
        } catch (\Exception $e) {
            Log::error('ASAAS PAYMENT ERROR', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
    
    private function createCustomer()
    {
        $customerData = [
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'cpfCnpj' => '11144477735' // CPF para testes
        ];
        
        Log::info('Creating Asaas customer', $customerData);
        
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'access_token' => env('ASAAS_API_KEY'),
        ])->post(env('ASAAS_BASE_URL') . '/customers', $customerData);
        
        Log::info('Customer response', [
            'status' => $response->status(),
            'body' => $response->json()
        ]);
        
        return $response->json();
    }
    
    private function calculateSplit($order)
    {
        $splits = [];
        $totalSplitValue = 0;
        
        foreach ($order->orderItems as $item) {
            $ticketPrice = (float) $item->ticket->initial_price;
            $platformFee = round($ticketPrice * 0.05, 2); // 5% para plataforma
            $sellerAmount = round($ticketPrice - $platformFee, 2);
            
            // Obter wallet do vendedor
            $sellerWalletId = $this->getSellerWalletId($item->ticket->event->seller_id);
            if (!$sellerWalletId) {
                throw new \Exception('Vendedor ID ' . $item->ticket->event->seller_id . ' não possui wallet Asaas');
            }
            
            // Split do vendedor
            $splits[] = [
                'walletId' => $sellerWalletId,
                'fixedValue' => $sellerAmount
            ];
            
            $totalSplitValue += $sellerAmount + $platformFee;
        }
        
        // Split da plataforma (soma de todas as taxas)
        $totalPlatformFee = round((float) $order->total_amount - array_sum(array_column($splits, 'fixedValue')), 2);
        
        $splits[] = [
            'walletId' => self::PLATFORM_WALLET_ID,
            'fixedValue' => $totalPlatformFee
        ];
        
        // Validar soma
        $splitSum = array_sum(array_column($splits, 'fixedValue'));
        $orderTotal = (float) $order->total_amount;
        
        if (abs($splitSum - $orderTotal) > 0.01) {
            Log::error('SPLIT SUM MISMATCH', [
                'order_total' => $orderTotal,
                'split_sum' => $splitSum,
                'difference' => $splitSum - $orderTotal,
                'splits' => $splits
            ]);
            throw new \Exception("Soma dos splits ($splitSum) não confere com total ($orderTotal)");
        }
        
        Log::info('Split calculated', [
            'order_total' => $orderTotal,
            'split_sum' => $splitSum,
            'splits' => $splits
        ]);
        
        return $splits;
    }
    
    private function getSellerWalletId($sellerId)
    {
        $seller = \App\Models\Seller::find($sellerId);
        return $seller?->asaas_wallet_id;
    }
    
    private function getBillingType($paymentMethod)
    {
        return match($paymentMethod) {
            'credit_card' => 'CREDIT_CARD',
            'pix' => 'PIX',
            'boleto' => 'BOLETO',
            default => 'PIX'
        };
    }
    
    public function getPayment($paymentId)
    {
        $response = Http::withHeaders([
            'access_token' => env('ASAAS_API_KEY'),
        ])->get(env('ASAAS_BASE_URL') . '/payments/' . $paymentId);
        
        Log::info('Get payment response', [
            'payment_id' => $paymentId,
            'status' => $response->status(),
            'body' => $response->json()
        ]);
        
        return $response->json();
    }
}