<?php

namespace App\Http\Controllers;

use App\Models\Ingresso;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IngressoController extends Controller
{
    public function index()
    {
        $ingressos = Ingresso::with('vendedor')
            ->join('vendedores', 'ingressos.id_vendedor', '=', 'vendedores.id_vendedor')
            ->orderBy('vendedores.nivel', 'desc')
            ->limit(20) 
            ->get();

        return view('index', ['ingressos' => $ingressos->ToArray()]);
    }
}
