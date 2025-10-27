<?php

namespace App\Services;

use App\Repositories\Interfaces\AsaasRepositoryInterface;
use Illuminate\Support\Facades\Log;

class AsaasSplitService
{
    private $asaasRepo;
    
    // IDs das carteiras - CONFIGURE AQUI
    private const PLATFORM_WALLET_ID = 'wallet_empresa_001'; // Substitua pelo walletId da plataforma
    
    public function __construct(AsaasRepositoryInterface $asaasRepo)
    {
        $this->asaasRepo = $asaasRepo;
    }
    
    public function createPaymentWithSplit($order, $request, $customerId)
    {
        // Calcular valores do split
        $splitData = $this->calculateSplit($order);
        
        // Validar se a soma dos splits bate com o total
        if (!$this->validateSplitSum($splitData, $order->total_amount)) {
            throw new \Exception('Soma dos splits não confere com o valor total');
        }
        
        // Preparar dados do pagamento
        $paymentData = [
            'customer' => $customerId,
            'billingType' => $this->getBillingType($request->payment_method),
            'value' => $order->total_amount,
            'description' => $this->getPaymentDescription($order),
            'dueDate' => now()->addDays(1)->format('Y-m-d'),
            'split' => $splitData['splits']
        ];
        
        // Adicionar dados específicos do método de pagamento
        $paymentData = $this->addPaymentMethodData($paymentData, $request);
        
        // Adicionar URLs de callback
        $paymentData['callback'] = [
            'successUrl' => route('payment.success'),
            'autoRedirect' => false
        ];
        
        Log::info('Criando pagamento com split:', [
            'total' => $order->total_amount,
            'splits' => $splitData['splits'],
            'validation' => $splitData['validation']
        ]);
        
        return $this->asaasRepo->createPayment($paymentData);
    }
    
    private function calculateSplit($order)
    {
        $totalAmount = $order->total_amount;
        $platformFee = 0;
        $sellerAmount = 0;
        $splits = [];
        
        foreach ($order->orderItems as $item) {
            $ticketPrice = $item->ticket->initial_price;
            $fee = $ticketPrice * 0.05; // 5% de taxa da plataforma
            
            $platformFee += $fee;
            $sellerAmount += ($ticketPrice - $fee);
            
            // Obter walletId do vendedor
            $sellerWalletId = $this->getSellerWalletId($item->ticket->event->seller_id);
            
            if (!$sellerWalletId) {
                throw new \Exception('Vendedor não possui carteira Asaas configurada');
            }
            
            // Adicionar split do vendedor (se ainda não existe)
            $existingSeller = array_search($sellerWalletId, array_column($splits, 'walletId'));
            if ($existingSeller !== false) {
                $splits[$existingSeller]['fixedValue'] += ($ticketPrice - $fee);
            } else {
                $splits[] = [
                    'walletId' => $sellerWalletId,
                    'fixedValue' => round($ticketPrice - $fee, 2)
                ];
            }
        }
        
        // Adicionar split da plataforma
        $splits[] = [
            'walletId' => self::PLATFORM_WALLET_ID,
            'fixedValue' => round($platformFee, 2)
        ];
        
        return [
            'splits' => $splits,
            'validation' => [
                'total' => $totalAmount,
                'platform_fee' => round($platformFee, 2),
                'seller_amount' => round($sellerAmount, 2),
                'sum' => round($platformFee + $sellerAmount, 2)
            ]
        ];
    }
    
    private function validateSplitSum($splitData, $totalAmount)
    {
        $splitSum = array_sum(array_column($splitData['splits'], 'fixedValue'));
        $difference = abs($splitSum - $totalAmount);
        
        // Aceitar diferença de até 0.01 por questões de arredondamento
        return $difference <= 0.01;
    }
    
    private function getSellerWalletId($sellerId)
    {
        // Buscar walletId do vendedor na tabela sellers
        $seller = \App\Models\Seller::find($sellerId);
        
        if (!$seller || !$seller->asaas_wallet_id) {
            return null;
        }
        
        return $seller->asaas_wallet_id;
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
    
    private function getPaymentDescription($order)
    {
        $description = 'Pedido #' . $order->order_number;
        foreach($order->orderItems as $item) {
            $description .= ' - ' . $item->ticket->event->title;
        }
        return $description;
    }
    
    private function addPaymentMethodData($paymentData, $request)
    {
        if ($request->payment_method === 'credit_card') {
            $paymentData['creditCard'] = [
                'holderName' => $request->card_name,
                'number' => str_replace(' ', '', $request->card_number),
                'expiryMonth' => substr($request->card_expiry, 0, 2),
                'expiryYear' => '20' . substr($request->card_expiry, 3, 2),
                'ccv' => $request->card_cvv
            ];
            
            $paymentData['creditCardHolderInfo'] = [
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'cpfCnpj' => '11144477735', // CPF para testes
                'postalCode' => '01310-100',
                'addressNumber' => '123',
                'phone' => '11999999999'
            ];
        } elseif ($request->payment_method === 'boleto') {
            $paymentData['dueDate'] = now()->addDays(3)->format('Y-m-d');
        }
        
        return $paymentData;
    }
    
    public function createSellerSubAccount($sellerData)
    {
        $subAccountData = [
            'name' => $sellerData['name'],
            'email' => $sellerData['email'],
            'cpfCnpj' => $sellerData['cpf'],
            'birthDate' => $sellerData['birth_date'] ?? '1990-01-01',
            'companyType' => 'INDIVIDUAL',
            'phone' => $sellerData['phone'] ?? '11999999999',
            'mobilePhone' => $sellerData['phone'] ?? '11999999999',
            'address' => $sellerData['address'] ?? 'Rua Exemplo, 123',
            'addressNumber' => $sellerData['address_number'] ?? '123',
            'complement' => $sellerData['complement'] ?? '',
            'province' => $sellerData['neighborhood'] ?? 'Centro',
            'postalCode' => $sellerData['postal_code'] ?? '01310-100'
        ];
        
        return $this->asaasRepo->createSubAccount($subAccountData);
    }
}