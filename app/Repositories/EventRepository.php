<?php

namespace App\Repositories;

use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Models\Event;

class EventRepository implements EventRepositoryInterface
{
    protected $model;

    public function __construct(Event $event)
    {
        $this->model = $event;
    }

    public function getTopEvents()
    {
        return $this->model->select('events.*')
            ->selectRaw('MIN(tickets.initial_price) as menor_preco')
            ->leftJoin('tickets', 'events.event_id', '=', 'tickets.event_id')
            ->where('tickets.status', 'Disponível')
            ->groupBy('events.event_id')
            ->orderBy('events.start_event_date')
            ->limit(20)
            ->get();
    }

    public function filterEvents($filters = [])
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
        if (!empty($filters['location'])) {
            $query->where('location', 'like', '%' . $filters['location'] . '%');
        }

        return $query->get();
    }

    public function searchEvents($search)
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

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function getAllForSelect()
    {
        return $this->model->select('event_id', 'title', 'start_event_date')
                          ->where('start_event_date', '>=', now())
                          ->orderBy('start_event_date')
                          ->get();
    }

    public function findWithTickets($id)
    {
        return $this->model->with(['tickets', 'seller.user'])->findOrFail($id);
    }

    public function getEventsBySeller($sellerId)
    {
        return $this->model->select('events.*')
            ->selectRaw('MIN(tickets.initial_price) as menor_preco')
            ->selectRaw('COUNT(tickets.ticket_id) as total_tickets')
            ->leftJoin('tickets', 'events.event_id', '=', 'tickets.event_id')
            ->where('events.seller_id', $sellerId)
            ->where('tickets.status', 'Disponível')
            ->groupBy('events.event_id')
            ->orderBy('events.start_event_date')
            ->get();
    }

    public function update($id, $data)
    {
        $event = $this->model->findOrFail($id);
        $event->update($data);
        return $event;
    }

    public function delete($id)
    {
        return $this->model->findOrFail($id)->delete();
    }

    public function canDelete($id)
    {
        return !$this->model->join('tickets', 'events.event_id', '=', 'tickets.event_id')
            ->where('events.event_id', $id)
            ->where('tickets.status', 'Vendido')
            ->exists();
    }
}