<?php

namespace App\Repositories\Interfaces;

interface SellerRepositoryInterface
{
    public function create($data);
    public function findByUserId($userId);
}