<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'name',
        'password',
        'birth',
        'cpf_cnpj',
        'telephone',
        'email',
    ];

    public function seller() {
        return $this->hasOne('App\Models\Seller');
    }

    public function buyer() {
        return $this->hasOne('App\Models\Buyer');
    }
}
