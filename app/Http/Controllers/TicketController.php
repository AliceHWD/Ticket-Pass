<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Repositories\Interfaces\EventRepositoryInterface;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected $ticketRepo;
    protected $eventRepo;

    public function __construct(TicketRepositoryInterface $ticketRepo, EventRepositoryInterface $eventRepo)
    {
        $this->ticketRepo = $ticketRepo;
        $this->eventRepo = $eventRepo;
    }

    public function index() {}

    public function search() {}

    public function filter(Request $request) {}

    public function show($id) {}

    public function create(Request $request)
    {
        $eventId = $request->get('event_id');
        $events = $this->eventRepo->getAllForSelect();

        return view('tickets.create', compact('events', 'eventId'));
    }

    public function store()
    {
        $data = request()->validate([
            'descricao' => 'nullable|string',
            'initial_price' => 'required|numeric|min:0',
            'event_id' => 'required|exists:events,event_id',
            'codes' => 'required|array|min:1',
            'codes.*' => 'required|string|max:255|distinct',
        ]);

        foreach ($data['codes'] as $code) {
            $this->ticketRepo->create([
                'code' => $code,
                'status' => 'Disponível',
                'descricao' => $data['descricao'],
                'initial_price' => $data['initial_price'],
                'event_id' => $data['event_id'],
            ]);
        }

        return redirect()->route('tickets.create')->with('success', 'Ingressos criados com sucesso!');
    }

    public function edit($id)
    {
        $ticket = $this->ticketRepo->findById($id);
        $event = $this->eventRepo->findById($ticket->event_id);
        
        if ($event->seller_id != \Auth::id()) {
            abort(403, 'Você não tem permissão para editar este ingresso.');
        }
        
        return view('tickets.edit', compact('ticket', 'event'));
    }

    public function update(Request $request, $id)
    {
        $ticket = $this->ticketRepo->findById($id);
        $event = $this->eventRepo->findById($ticket->event_id);
        
        if ($event->seller_id != \Auth::id()) {
            abort(403, 'Você não tem permissão para editar este ingresso.');
        }
        
        $data = $request->validate([
            'descricao' => 'nullable|string',
            'initial_price' => 'required|numeric|min:0',
            'code' => 'required|string|max:255',
        ]);
        
        $this->ticketRepo->update($id, $data);
        
        return redirect()->route('events.show', $ticket->event_id)->with('success', 'Ingresso atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $ticket = $this->ticketRepo->findById($id);
        $event = $this->eventRepo->findById($ticket->event_id);
        
        if ($event->seller_id != \Auth::id()) {
            abort(403, 'Você não tem permissão para deletar este ingresso.');
        }
        
        if (!$this->ticketRepo->canDelete($id)) {
            return redirect()->back()->with('error', 'Não é possível deletar este ingresso pois já foi vendido.');
        }
        
        $this->ticketRepo->delete($id);
        
        return redirect()->route('events.show', $ticket->event_id)->with('success', 'Ingresso deletado com sucesso!');
    }
}