<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    use HasFactory;

    protected $table = 'vendedores';
    protected $primaryKey = 'id_vendedor';

    protected $fillable = [
        'id_usuario',
        'avaliacao',
        'nivel',
        'cep',
        'numero_domicilio',
        'complemento',
    ];

    public function usuario() {
        return $this->belongsTo('App\Models\Usuario');
    }

    public function ingressos() {
        return $this->hasMany('App\Models\Ingresso');
    }
}
