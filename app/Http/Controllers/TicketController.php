<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\Ticket as AttributesTicket;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('seller')
            ->join('sellers', 'tickets.seller_id', '=', 'sellers.seller_id')
            ->orderBy('sellers.level', 'desc')
            ->limit(20)
            ->get();

        return view('index', ['ingressos' => $tickets->ToArray()]);
    }

    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);

        return view('tickets.show', ['ticket' => $ticket]);
    }

    public function search(){
        $search = request('search'); // pega o que o usuário escreveu

        if ($search) { // se o usuário fizer uma pesquisa aparece só o que ele quer

            $tickets = Ticket::where([
                ['title', 'like', '%' . $search . '%']
            ])->get();

        } else {
            $tickets = Ticket::all();
        }

        return view('search', ['tickets' => $tickets]);
    }
}
