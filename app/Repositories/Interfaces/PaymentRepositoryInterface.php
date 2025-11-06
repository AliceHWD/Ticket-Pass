<?php

namespace App\Repositories\Interfaces;

interface PaymentRepositoryInterface
{
    public function findOrderById($orderId);
    public function createPayment($data);
    public function updateOrderStatus($orderId, $data);
    public function updateTicketsStatus($orderItems);
    public function findByExternalId($externalId);
    public function updatePaymentStatus($paymentId, $status);
}