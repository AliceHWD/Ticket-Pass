<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';

    protected $fillable = [
        'status',
        'order_date',
        'payment',
        'buyer_id',
        'order_number',
        'total_amount'
    ];

    public function buyer() {
        return $this->belongsTo('App\Models\Buyer');
    }

    public function tickets() {
        return $this->belongsToMany('App\Models\Ticket', 'order_items', 'order_id', 'ticket_id')->withPivot('quantity');
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }

    public function payment() {
        return $this->hasOne(Payment::class, 'order_id', 'order_id');
    }
}
