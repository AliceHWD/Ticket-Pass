@extends('layouts.main')

@section('titulo', 'Detalhes do Evento')
@section('css', '/css/evento.css')

@section('conteudo')

    <div class="content">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <h2>{{ $event->title }}</h2>
        <p>Local: {{ $event->location }}</p>
        <p>Data: {{ \Carbon\Carbon::parse($event->start_event_date)->format('d/m/Y') }}</p>
        <p>Horário: {{ $event->start_event_time }}</p>
        <p>Categoria: {{ $event->category }}</p>
        @if ($event->description)
            <p>Descrição: {{ $event->description }}</p>
        @endif

        @if ($event->seller && $event->seller->user)
            <div class="event-seller">
                <h4>Vendedor:</h4>
                <p>{{ $event->seller->user->name }}</p>
                @if ($event->seller->level)
                    <span class="seller-level">Nível: {{ $event->seller->level }}</span>
                @endif
            </div>
        @endif

        @auth
            @if ($event->seller && $event->seller->user_id == Auth::id())
                <div class="seller-actions mb-3">
                    <a href="{{ route('tickets.create', ['event_id' => $event->event_id]) }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Adicionar Ingressos
                    </a>
                    <a href="{{ route('events.edit', $event->event_id) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Editar Evento
                    </a>
                    <form method="POST" action="{{ route('events.destroy', $event->event_id) }}" style="display: inline;"
                        onsubmit="return confirm('Tem certeza que deseja deletar este evento?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Deletar Evento
                        </button>
                    </form>
                </div>
            @endif
        @endauth

        @if ($event->tickets->count() > 0)
            <h3>Ingressos Disponíveis:</h3>
            <div class="tickets-list">
                @foreach ($event->tickets as $ticket)
                    @if ($ticket->status == 'Disponível')
                        <div class="ticket-item">
                            <p><strong>Código:</strong> {{ $ticket->code }}</p>
                            <p><strong>Preço:</strong> R$ {{ number_format($ticket->initial_price, 2, ',', '.') }}</p>
                            @if ($ticket->descricao)
                                <p><strong>Detalhes:</strong> {{ $ticket->descricao }}</p>
                            @endif

                            @auth
                                @if ($event->seller && $event->seller->user_id == Auth::id() && $ticket->status == 'Disponível')
                                    <div class="ticket-actions mt-2">
                                        <a href="{{ route('tickets.edit', $ticket->ticket_id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <form method="POST" action="{{ route('tickets.destroy', $ticket->ticket_id) }}"
                                            style="display: inline;"
                                            onsubmit="return confirm('Tem certeza que deseja deletar este ingresso?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Deletar
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                            @auth
                                @if(!($event->seller && $event->seller->user_id == Auth::id()))
                                    <div class="ticket-actions mt-2">
                                        <form method="POST" action="{{ route('cart.add') }}" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="ticket_id" value="{{ $ticket->ticket_id }}">
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-cart-plus"></i> Adicionar ao Carrinho
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @else
                                <div class="ticket-actions mt-2">
                                    <form method="POST" action="{{ route('cart.add') }}" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="ticket_id" value="{{ $ticket->ticket_id }}">
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fas fa-cart-plus"></i> Adicionar ao Carrinho
                                        </button>
                                    </form>
                                </div>
                            @endauth
                            <hr>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <p>Nenhum ingresso disponível para este evento.</p>
        @endif
    </div>

@endsection