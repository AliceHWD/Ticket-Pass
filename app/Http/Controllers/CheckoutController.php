<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\CartRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    protected $cartRepo;

    public function __construct(CartRepositoryInterface $cartRepo)
    {
        $this->cartRepo = $cartRepo;
    }

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Faça login para finalizar a compra.');
        }

        $cartItems = $this->cartRepo->getCartItems(Auth::id(), null);
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Carrinho vazio.');
        }

        // Validar se ingressos ainda estão disponíveis
        foreach ($cartItems as $item) {
            if ($item->ticket->status !== 'Disponível') {
                $this->cartRepo->removeFromCart($item->id, Auth::id(), null);
                return redirect()->route('cart.index')->with('error', 'Ingresso "' . $item->ticket->code . '" não está mais disponível e foi removido do carrinho.');
            }
        }

        // Calcular valores
        $subtotal = $cartItems->sum(function($item) { return $item->ticket->initial_price; });
        $taxa = $subtotal * 0.05; // 5% de taxa
        $total = $subtotal + $taxa;

        return view('checkout', compact('cartItems', 'subtotal', 'taxa', 'total'));
    }
}
