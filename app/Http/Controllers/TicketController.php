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
        return view('index', ['ingressos' => $tickets->toArray()]);
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

    // 📅 Método auxiliar para converter data
    private function formatDate($date)
    {
        if (empty($date)) {
            return null;
        }

        // Converte dd/mm/yyyy para yyyy-mm-dd
        return \Carbon\Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
    }

    public function filter()
    {
        $filters = [
            'date' => request('date'),
            'precoMinimo' => request('precoMinimo'),
            'precoMaximo' => request('precoMaximo'),
            'location' => request('localizacao'),
            'categories' => $this->getSelectedCategories()
        ];

        $tickets = $this->ticketRepo->filterTickets($filters);

        return view('search', [
            'tickets' => $tickets,
            'filters' => $filters
        ]);
    }

    private function getSelectedCategories()
    {
        $categories = request('categories', []);

        // Retorna apenas as categorias selecionadas
        return $categories;
    }

    public function show($id)
    {
        $ticket = $this->ticketRepo->findById($id);
        return view('tickets.show', ['ticket' => $ticket]);
    }
}
