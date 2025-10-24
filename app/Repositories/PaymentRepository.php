<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Payment;
use App\Repositories\Interfaces\PaymentRepositoryInterface;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function findOrderById($orderId)
    {
        return Order::findOrFail($orderId);
    }

    public function createPayment($data)
    {
        return Payment::create($data);
    }

    public function updateOrderStatus($orderId, $data)
    {
        $order = Order::findOrFail($orderId);
        $order->update($data);
        return $order;
    }

    public function updateTicketsStatus($orderItems)
    {
        foreach($orderItems as $item) {
            $item->ticket->update(['status' => 'Vendido']);
        }
    }
}