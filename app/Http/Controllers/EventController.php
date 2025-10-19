<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\EventRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected $eventRepo;

    public function __construct(EventRepositoryInterface $eventRepo)
    {
        $this->eventRepo = $eventRepo;
    }

    public function index()
    {
        $events = $this->eventRepo->getTopEvents();

        return view('index', ['ingressos' => $events]);
    }

    public function search()
    {
        $search = request('search');
        $events = $this->eventRepo->searchEvents($search);

        return view('search', [
            'events' => $events,
            'searchTerm' => $search,
        ]);
    }

    public function filter(Request $request)
    {
        $filters = $request->validate([
            'date' => 'nullable|date',
            'precoMinimo' => 'nullable|decimal:2',
            'precoMaximo' => 'nullable|decimal:2',
            'location' => 'nullable|string|max:255',
            'categories' => 'nullable|array',
        ]);

        $events = $this->eventRepo->filterEvents($filters);

        return view('search', [
            'events' => $events,
            'filters' => $filters,
        ]);
    }

    public function show($id)
    {
        $event = $this->eventRepo->findWithTickets($id);

        return view('events.show', ['event' => $event]);
    }

    public function create()
    {
        return view('events.create');
    }

    public function store()
    {
        $data = request()->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_event_date' => 'required|date',
            'start_event_time' => 'required|date_format:H:i',
            'end_event_date' => 'required|date',
            'end_event_time' => 'required|date_format:H:i',
            'category' => 'required|string',
            'location' => 'required|string|max:255',
            'cep' => 'required|string|max:255',
            'location_number' => 'required|integer',
        ]);

        $data['seller_id'] = Auth::id(); 

        $event = $this->eventRepo->create($data);

        return redirect()->route('tickets.create', ['event_id' => $event->event_id]);
    }

    public function edit($id)
    {
        $event = $this->eventRepo->findById($id);
        
        if ($event->seller_id != Auth::id()) {
            abort(403, 'Você não tem permissão para editar este evento.');
        }
        
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = $this->eventRepo->findById($id);
        
        if ($event->seller_id != Auth::id()) {
            abort(403, 'Você não tem permissão para editar este evento.');
        }
        
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_event_date' => 'required|date',
            'start_event_time' => 'required|date_format:H:i',
            'end_event_date' => 'required|date',
            'end_event_time' => 'required|date_format:H:i',
            'category' => 'required|string',
            'location' => 'required|string|max:255',
            'cep' => 'required|string|max:255',
            'location_number' => 'required|integer',
        ]);
        
        $this->eventRepo->update($id, $data);
        
        return redirect()->route('events.show', $id)->with('success', 'Evento atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $event = $this->eventRepo->findById($id);
        
        if ($event->seller_id != Auth::id()) {
            abort(403, 'Você não tem permissão para deletar este evento.');
        }
        
        if (!$this->eventRepo->canDelete($id)) {
            return redirect()->back()->with('error', 'Não é possível deletar este evento pois possui ingressos vendidos.');
        }
        
        $this->eventRepo->delete($id);
        
        return redirect()->route('seller.index')->with('success', 'Evento deletado com sucesso!');
    }
}