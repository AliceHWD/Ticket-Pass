<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comprador extends Model
{
    use HasFactory;

    protected $table = 'compradores';
    protected $primaryKey = 'id_comprador';

    protected $fillable = [
        'id_usuario',
    ];

    public function usuario() {
        return $this->belongsTo('App\Models\Usuario');
    }

    public function pedidos() {
        return $this->hasMany('App\Models\Pedido');
    }
}
