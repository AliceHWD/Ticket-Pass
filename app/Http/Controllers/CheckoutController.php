<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CheckoutController extends Controller
{
    protected $cartRepo;
    protected $orderRepo;

    public function __construct(CartRepositoryInterface $cartRepo, OrderRepositoryInterface $orderRepo)
    {
        $this->cartRepo = $cartRepo;
        $this->orderRepo = $orderRepo;
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

    public function process()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cartItems = $this->cartRepo->getCartItems(Auth::id(), null);
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Carrinho vazio.');
        }

        // Calcular total
        $subtotal = $cartItems->sum(function($item) { return $item->ticket->initial_price; });
        $taxa = $subtotal * 0.05;
        $total = $subtotal + $taxa;

        // Gerar número único do pedido
        $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));

        // Verificar se usuário tem buyer_id
        $buyer = $this->orderRepo->findOrCreateBuyer(Auth::id());

        // Criar order
        $order = $this->orderRepo->createOrder([
            'order_number' => $orderNumber,
            'buyer_id' => $buyer->buyer_id,
            'status' => 'pendente',
            'order_date' => now(),
            'payment' => 'pending',
            'total_amount' => $total
        ]);

        // Criar order_items
        $this->orderRepo->createOrderItems($order->order_id, $cartItems);

        // Limpar carrinho
        foreach ($cartItems as $item) {
            $this->cartRepo->removeFromCart($item->id, Auth::id(), null);
        }

        return redirect()->route('payment.show', $order->order_id)->with('success', 'Pedido criado com sucesso! Número: ' . $orderNumber);
    }
}
