<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingresso extends Model
{
    use HasFactory;

    protected $primaryKey = 'idIngresso';

    protected $fillable = [
        'titulo',
        'local_evento',
        'valor_inicial',
        'data_evento',
        'valor_negociado',
        'modalidade_evento',
        'descricao',
        'id_vendedor',
        'status'
    ];

    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class);
    }

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'items_pedido', 'id_ingresso', 'id_pedido')->withPivot('quantidade');
    }
}
