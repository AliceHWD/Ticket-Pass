<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\PaymentRepositoryInterface;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $paymentRepo;

    public function __construct(PaymentRepositoryInterface $paymentRepo)
    {
        $this->paymentRepo = $paymentRepo;
    }

    public function show($orderId)
    {
        $order = $this->paymentRepo->findOrderById($orderId);
        return view('payment.show', compact('order'));
    }

    public function process($orderId, Request $request)
    {
        $order = $this->paymentRepo->findOrderById($orderId);
        
        $request->validate([
            'payment_method' => 'required|in:credit_card,debit_card,pix'
        ]);

        // Criar registro de pagamento
        $this->paymentRepo->createPayment([
            'order_id' => $order->order_id,
            'payment_method' => $request->payment_method,
            'status' => 'completed',
            'amount' => $order->total_amount,
            'payment_date' => now()
        ]);

        // Atualizar status do pedido
        $this->paymentRepo->updateOrderStatus($orderId, [
            'status' => 'concluído',
            'payment' => $request->payment_method
        ]);
        
        // Atualizar status dos ingressos para vendido
        $this->paymentRepo->updateTicketsStatus($order->orderItems);
        
        $paymentMethod = $request->payment_method;
        return view('payment.success', compact('order', 'paymentMethod'));
    }
}