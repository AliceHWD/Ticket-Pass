<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $primaryKey = 'payment_id';
    
    protected $fillable = [
        'order_id',
        'payment_method',
        'status',
        'amount',
        'payment_date'
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'amount' => 'decimal:2'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}