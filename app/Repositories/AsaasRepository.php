<?php

namespace App\Repositories;

use App\Repositories\Interfaces\AsaasRepositoryInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AsaasRepository implements AsaasRepositoryInterface
{
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('asaas.api_key');
        $this->baseUrl = config('asaas.base_url');
    }

    public function createCustomer(array $data)
    {
        $response = Http::withHeaders([
            'access_token' => $this->apiKey,
            'Content-Type' => 'application/json'
        ])->post($this->baseUrl . '/customers', $data);

        Log::info('Asaas Create Customer Response:', $response->json());
        
        return $response->json();
    }

    public function createPayment(array $data)
    {
        Log::info('Asaas Create Payment Request:', $data);
        
        $response = Http::withHeaders([
            'access_token' => $this->apiKey,
            'Content-Type' => 'application/json'
        ])->post($this->baseUrl . '/payments', $data);

        Log::info('Asaas Create Payment Response:', $response->json());
        
        return $response->json();
    }

    public function getPayment(string $paymentId)
    {
        $response = Http::withHeaders([
            'access_token' => $this->apiKey
        ])->get($this->baseUrl . '/payments/' . $paymentId);

        return $response->json();
    }
    
    public function createSubAccount(array $data)
    {
        $response = Http::withHeaders([
            'access_token' => $this->apiKey,
            'Content-Type' => 'application/json'
        ])->post($this->baseUrl . '/accounts', $data);

        Log::info('Asaas Create SubAccount Response:', $response->json());
        
        return $response->json();
    }
    
    public function getSubAccount(string $accountId)
    {
        $response = Http::withHeaders([
            'access_token' => $this->apiKey
        ])->get($this->baseUrl . '/accounts/' . $accountId);

        return $response->json();
    }
}