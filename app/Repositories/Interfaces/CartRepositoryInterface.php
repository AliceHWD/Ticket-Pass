<?php

namespace App\Repositories\Interfaces;

interface CartRepositoryInterface
{
    public function getCartItems($userId = null, $sessionId = null);
    public function addToCart($data);
    public function removeFromCart($id, $userId = null, $sessionId = null);
}