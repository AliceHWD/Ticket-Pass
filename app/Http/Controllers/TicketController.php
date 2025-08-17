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
}
