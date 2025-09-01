<?php

namespace App\Repositories;

use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Models\Ticket;

class TicketRepository implements TicketRepositoryInterface
{
    protected $model;

    public function __construct(Ticket $ticket)
    {
        $this->model = $ticket;
    }

    public function getTopTickets()
    {
        $query = $this->model->newQuery();

        return $query->with('seller')
            ->join('sellers', 'tickets.seller_id', '=', 'sellers.seller_id')
            ->orderBy('sellers.level', 'desc')
            ->limit(20)
            ->get();;
    }

    public function filterTickets($filters = [])
    {
        $query = $this->model->newQuery();

        // Filtro de categorias (checkbox)
        if (!empty($filters['categories'])) {
            $query->whereIn('event_type', $filters['categories']);
        }

        // data
        if (!empty($filters['date'])) {
             $query->whereDate('event_date', '=', $filters['date']);
        }

        // preço mínimo
        if (!empty($filters['precoMinimo'])) {
            $query->where('initial_price', '>=', $filters['precoMinimo']);
        }

        // preço máximo
        if (!empty($filters['precoMaximo'])) {
            $query->where('initial_price', '<=', $filters['precoMaximo']);
        }

        // localização
        if (!empty($filters['location'])) {{
            $query->where('location', 'like', '%' . $filters['location'] . '%');
            }
        }

        return $query->get();
    }

    public function searchTickets($search)
    {
        $query = $this->model->newQuery();

        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        return $query->get();
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }
}
