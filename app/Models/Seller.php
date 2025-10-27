<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $table = 'sellers';
    protected $primaryKey = 'seller_id';

    protected $fillable = [
        'user_id',
        'rating',
        'level',
        'cep',
        'house_number',
        'complement',
        'asaas_wallet_id',
        'asaas_account_id',
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function tickets() {
        return $this->hasMany('App\Models\Ticket');
    }
}
