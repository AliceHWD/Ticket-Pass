<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $primaryKey = 'event_id';
    protected $table = 'events';

    protected $fillable = [
        'title',
        'location',
        'start_event_date',
        'start_event_time',
        'end_event_date',
        'end_event_time',
        'description',
        'cep',
        'location_number',
        'seller_id',
        'category'
    ];

    public function seller()
    {
        return $this->belongsTo('App\Models\Seller', 'seller_id', 'seller_id');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order', 'order_items', 'event_id', 'order_id')->withPivot('quantity');
    }

    public function tickets()
    {
        return $this->hasMany('App\Models\Ticket', 'event_id', 'event_id');
    }
}