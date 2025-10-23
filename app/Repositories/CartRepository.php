<?php

namespace App\Repositories;

use App\Models\CartItem;
use App\Repositories\Interfaces\CartRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CartRepository implements CartRepositoryInterface
{
    protected $model;

    public function __construct(CartItem $model)
    {
        $this->model = $model;
    }

    public function getCartItems($userId = null, $sessionId = null)
    {
        $query = $this->model->with(['ticket.event']);
        
        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->where('session_id', $sessionId);
        }
        
        return $query->get();
    }

    public function addToCart($data)
    {
        return $this->model->firstOrCreate(
            [
                'user_id' => $data['user_id'],
                'session_id' => $data['session_id'],
                'ticket_id' => $data['ticket_id']
            ]
        );
    }

    public function removeFromCart($id, $userId = null, $sessionId = null)
    {
        $query = $this->model->where('id', $id);
        
        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->where('session_id', $sessionId);
        }
        
        return $query->delete();
    }
}