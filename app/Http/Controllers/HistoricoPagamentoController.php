<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoricoPagamentoController extends Controller
{
    public function index()
    {
        // Buscar todos os pedidos do usuário logado
        $userOrders = Order::where('user_id', Auth::id())->pluck('order_id');
        
        // Buscar pagamentos desses pedidos
        $payments = Payment::whereIn('order_id', $userOrders)
            ->with(['order.orderItems.ticket.event'])
            ->orderBy('payment_date', 'desc')
            ->get();

        return view('historico_pagamento', compact('payments'));
    }
}