<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestAsaasIntegration extends Command
{
    protected $signature = 'asaas:test';
    protected $description = 'Testa a integração com Asaas';

    public function handle()
    {
        $this->info('=== TESTE DE INTEGRAÇÃO ASAAS ===');
        
        $apiKey = env('ASAAS_API_KEY');
        if (!$apiKey) {
            $this->error('ASAAS_API_KEY não configurada no .env');
            return;
        }
        
        $this->info('API Key: ' . substr($apiKey, 0, 10) . '...');
        
        // Teste: Criar pagamento simples
        $customerData = [
            'name' => 'Teste Cliente',
            'email' => 'teste@exemplo.com',
            'cpfCnpj' => '11144477735',
            'mobilePhone' => '11987654321'
        ];
        
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'access_token' => $apiKey,
        ])->post('https://sandbox.asaas.com/api/v3/customers', $customerData);
        
        $this->info('Status Cliente: ' . $response->status());
        
        if ($response->successful()) {
            $customer = $response->json();
            $customerId = $customer['id'];
            
            $paymentData = [
                'customer' => $customerId,
                'billingType' => 'PIX',
                'value' => 129.15,
                'description' => 'Teste de pagamento',
                'dueDate' => date('Y-m-d', strtotime('+1 day'))
            ];
            
            $paymentResponse = Http::withHeaders([
                'Content-Type' => 'application/json',
                'access_token' => $apiKey,
            ])->post('https://sandbox.asaas.com/api/v3/payments', $paymentData);
            
            $this->info('Status Pagamento: ' . $paymentResponse->status());
            $this->info('Response: ' . $paymentResponse->body());
            
            if ($paymentResponse->successful()) {
                $this->info('✅ Integração funcionando!');
            } else {
                $this->error('❌ Erro no pagamento');
            }
        } else {
            $this->error('❌ Erro no cliente: ' . $response->body());
        }
    }
}