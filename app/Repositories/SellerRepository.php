<?php

namespace App\Repositories;

use App\Models\Seller;
use App\Repositories\Interfaces\SellerRepositoryInterface;

class SellerRepository implements SellerRepositoryInterface
{
    protected $model;

    public function __construct(Seller $model)
    {
        $this->model = $model;
    }

    public function create($data)
    {
        return $this->model->create($data);
    }
}
