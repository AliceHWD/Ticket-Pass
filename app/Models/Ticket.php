<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $primaryKey = 'ticket_id';

    protected $fillable = [
        'title',
        'lacation',
        'initial_price',
        'event_date',
        'negotiated_price',
        'event_type',
        'description',
        'buyer_id',
        'status',
        'image'
    ];

    public function seller()
    {
        return $this->belongsTo('App\Models\Seller');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order', 'order_items', 'ticket_id', 'order_id')->withPivot('quantity');
    }
}
