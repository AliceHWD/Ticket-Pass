<?php

namespace App\Repositories;

use App\Models\Event;
use App\Repositories\Interfaces\EventRepositoryInterface;

class EventRepository implements EventRepositoryInterface
{
    protected $model;

    public function __construct(Event $event)
    {
        $this->model = $event;
    }

    public function getTopEvents()
    {
        return Event::withMin('tickets', 'initial_price')
            ->whereHas('tickets', fn ($q) => $q->where('status', 'Disponível'))
            ->orderBy('start_event_date', 'asc')
            ->take(20)
            ->get();
    }

    public function searchEvents($search)
    {
        $query = $this->model->newQuery();

        if ($search) {
            $query->where('title', 'like', '%'.$search.'%');
        }

        return $query->with('tickets')->get();
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
        return Event::withMin('tickets', 'initial_price') // menor_preco
            ->withCount(['tickets as total_tickets' => function ($query) {
                $query->where('status', 'Disponível');
            }])
            ->where('seller_id', $sellerId)
            ->whereHas('tickets', function ($query) {
                $query->where('status', 'Disponível');
            })
            ->orderBy('start_event_date')
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
        return ! $this->model->join('tickets', 'events.event_id', '=', 'tickets.event_id')
            ->where('events.event_id', $id)
            ->where('tickets.status', 'Vendido')
            ->exists();
    }
}
