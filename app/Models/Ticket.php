<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $primaryKey = 'ticket_id';
    public $timestamps = false;

    protected $fillable = [
        'initial_price',
        'event_id',
        'code',
        'status',
        'descricao'
    ];

    public function event()
    {
        return $this->belongsTo('App\Models\Event', 'event_id', 'event_id');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order', 'order_items', 'ticket_id', 'order_id');
    }
}
