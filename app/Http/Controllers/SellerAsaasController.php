<?php

namespace App\Http\Controllers;

use App\Services\AsaasSplitService;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SellerAsaasController extends Controller
{
    protected $splitService;

    public function __construct(AsaasSplitService $splitService)
    {
        $this->splitService = $splitService;
    }

    public function createSubAccount(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'cpf' => 'required|string|size:11',
            'phone' => 'required|string',
            'birth_date' => 'required|date',
            'address' => 'required|string',
            'address_number' => 'required|string',
            'neighborhood' => 'required|string',
            'postal_code' => 'required|string|size:8'
        ]);

        try {
            $seller = Seller::where('user_id', Auth::id())->first();
            
            if (!$seller) {
                return redirect()->back()->with('error', 'Vendedor não encontrado');
            }

            if ($seller->asaas_account_id) {
                return redirect()->back()->with('info', 'Subconta Asaas já existe');
            }

            $subAccountData = [
                'name' => $request->name,
                'email' => $request->email,
                'cpf' => $request->cpf,
                'phone' => $request->phone,
                'birth_date' => $request->birth_date,
                'address' => $request->address,
                'address_number' => $request->address_number,
                'complement' => $request->complement,
                'neighborhood' => $request->neighborhood,
                'postal_code' => $request->postal_code
            ];

            $response = $this->splitService->createSellerSubAccount($subAccountData);

            if (isset($response['errors'])) {
                $errorMessages = [];
                foreach($response['errors'] as $error) {
                    $errorMessages[] = $error['description'] ?? $error['code'];
                }
                return redirect()->back()->with('error', 'Erro ao criar subconta: ' . implode(', ', $errorMessages));
            }

            // Salvar IDs da subconta
            $seller->update([
                'asaas_account_id' => $response['id'],
                'asaas_wallet_id' => $response['walletId'] ?? $response['id'] // Usar ID como walletId se não retornar walletId específico
            ]);

            Log::info('Subconta Asaas criada:', [
                'seller_id' => $seller->seller_id,
                'account_id' => $response['id'],
                'wallet_id' => $response['walletId'] ?? $response['id']
            ]);

            return redirect()->back()->with('success', 'Subconta Asaas criada com sucesso!');

        } catch (\Exception $e) {
            Log::error('Erro ao criar subconta Asaas:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro interno: ' . $e->getMessage());
        }
    }

    public function showSubAccountForm()
    {
        $seller = Seller::where('user_id', Auth::id())->first();
        
        return view('seller.asaas-setup', compact('seller'));
    }
}