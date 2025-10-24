<?php

namespace App\Repositories;

use App\Models\Buyer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function findOrCreateBuyer($userId)
    {
        return Buyer::firstOrCreate(['user_id' => $userId]);
    }

    public function createOrder($data)
    {
        return Order::create($data);
    }

    public function createOrderItems($orderId, $cartItems)
    {
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $orderId,
                'ticket_id' => $item->ticket_id,
                'quantity' => 1
            ]);
        }
    }
}