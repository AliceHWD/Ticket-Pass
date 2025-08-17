<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'nome',
        'senha',
        'data_nascimento',
        'cpf_cnpj',
        'telefone',
        'email',
    ];

    public function vendedor() {
        return $this->hasOne('App\Models\Vendedor');
    }

    public function comprador() {
        return $this->hasOne('App\Models\Comprador');
    }
}
