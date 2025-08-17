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
        'payment'
    ];

    public function buyer() {
        return $this->belongsTo('App\Models\Buyer');
    }

    public function tickets() {
        return $this->belongsToMany('App\Models\Ticket', 'order_items', 'order_id', 'ticket_id')->withPivot('quantity');
    }
}
