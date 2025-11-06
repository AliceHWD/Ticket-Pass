<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class MyTicketsController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Buscar todos os pedidos do usuário
        $orders = Order::with(['orderItems.ticket.event', 'payment'])
            ->whereHas('buyer', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->orderBy('order_date', 'desc')
            ->get();

        // Organizar por status
        $confirmedOrders = $orders->where('status', 'concluído');
        $pendingOrders = $orders->where('status', 'pendente');
        $cancelledOrders = $orders->where('status', 'cancelado');

        return view('my-tickets', compact('confirmedOrders', 'pendingOrders', 'cancelledOrders'));
    }
}