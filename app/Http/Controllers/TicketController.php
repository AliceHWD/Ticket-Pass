<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\TicketRepositoryInterface;
use Illuminate\Http\Request;


class TicketController extends Controller
{
    protected $ticketRepo;

    public function __construct(TicketRepositoryInterface $ticketRepo)
    {
        $this->ticketRepo = $ticketRepo;
    }

    public function index()
    {
        $tickets = $this->ticketRepo->getTopTickets();
        return view('index', ['ingressos' => $tickets]);
    }

    public function search()
    {
        $search = request('search');
        $tickets = $this->ticketRepo->searchTickets($search);

        return view('search', [
            'tickets' => $tickets,
            'searchTerm' => $search
        ]);
    }

    public function filter(Request $request)
    {
        $filters = $request->validate([
            'date' => 'nullable|date',
            'precoMinimo' => 'nullable|decimal:2',
            'precoMaximo' => 'nullable|decimal:2',
            'location' => 'nullable|string|max:255',
            'categories' => 'nullable|array'
        ]);

        $tickets = $this->ticketRepo->filterTickets($filters);

        return view('search', [
            'tickets' => $tickets,
            'filters' => $filters
        ]);
    }

    public function show($id)
    {
        $ticket = $this->ticketRepo->findById($id);
        return view('tickets.show', ['ticket' => $ticket]);
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store()
    {
        $data = request()->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'price' => 'required|decimal:2',
            'categories' => 'nullable|array'
        ]);

        $ticket = $this->ticketRepo->create($data);
        return view('tickets.create');
    }
}
