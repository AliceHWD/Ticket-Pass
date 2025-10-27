<?php

namespace App\Repositories\Interfaces;

interface AsaasRepositoryInterface
{
    public function createCustomer(array $data);
    public function createPayment(array $data);
    public function getPayment(string $paymentId);
    public function createSubAccount(array $data);
    public function getSubAccount(string $accountId);
}