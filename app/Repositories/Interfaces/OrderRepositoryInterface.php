<?php

namespace App\Repositories\Interfaces;

interface OrderRepositoryInterface
{
    public function findOrCreateBuyer($userId);
    public function createOrder($data);
    public function createOrderItems($orderId, $cartItems);
}