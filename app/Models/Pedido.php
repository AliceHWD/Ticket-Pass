<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pedido';

    protected $fillable = [
        'status',
        'data_pedido',
        'forma_pagamento'
    ];

    public function comprador() {
        return $this->belongsTo(Comprador::class);
    }

    public function ingressos() {
        return $this->belongsToMany(Ingresso::class, 'items_pedido', 'id_pedido', 'id_ingresso')->withPivot('quantidade');
    }
}
