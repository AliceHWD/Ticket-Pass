@extends('layouts.main')

@section('titulo', 'Detalhes do Evento')
@section('css', '/css/evento.css')

@section('conteudo')
    <div class="content">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="event-header">
            <h2></h2>
            <div class="event-image">
                <div class="event-image-title">{{ $event->title }}</div>
            </div>
            <div class="event-info-box">
                <p><strong>Local:</strong> {{ $event->location }}</p>
                <p><strong>Início:</strong> {{ \Carbon\Carbon::parse($event->start_event_date)->format('d/m/Y') }} às
                    {{ $event->start_event_time }}</p>
                <p><strong>Fim:</strong> {{ \Carbon\Carbon::parse($event->end_event_date)->format('d/m/Y') }} às
                    {{ $event->end_event_time }}</p>
                <p><strong>Categoria:</strong> {{ $event->category }}</p>
            </div>
        </div>

        @auth
            @if ($event->seller && $event->seller->user_id == Auth::id())
                <div class="seller-actions">
                    <a href="{{ route('tickets.create', ['event_id' => $event->event_id]) }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Adicionar Ingressos
                    </a>
                    <a href="{{ route('events.edit', $event->event_id) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Editar Evento
                    </a>
                    <form method="POST" action="{{ route('events.destroy', $event->event_id) }}"
                        style="display: inline;"
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

        <div class="event-details">
            <div class="event-left">
                <button class="btn-saiba-mais">Saiba mais</button>
                <p>{{ $event->description }}</p>
            </div>

            <div class="event-right">
                @if ($event->seller && $event->seller->user)
                    <div class="event-seller">
                        <div class="seller-avatar"></div>
                        <div class="seller-info">
                            <h4>{{ $event->seller->user->name }}</h4>
                            <p class="seller-rating">★★★★★</p>
                            <p class="seller-desc">Sobre o vendedor: Lorem ipsum dolor sit amet, consectetur adipiscing
                                elit...</p>
                        </div>
                    </div>
                @endif


            </div>
        </div>

        <h3>Ingressos disponíveis:</h3>
        <div class="tickets-list">
            @foreach ($event->tickets as $ticket)
                @if ($ticket->status == 'Disponível')
                    <div class="card">
                        <div class="card__shine"></div>
                        <div class="card__glow"></div>
                        <div class="card__content">
                            <div class="card__image"></div>
                            <div class="card__text">
                                <h4 class="card__title">Ingresso {{ $ticket->code }}</h4>
                                <p class="card__description">{{ $ticket->descricao }}</p>
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
                                    @if (!($event->seller && $event->seller->user_id == Auth::id()))
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
                                    <div class="card__footer">
                                        <p class="card__price">R$ {{ number_format($ticket->initial_price, 2, ',', '.') }}</p>
                                        <form method="POST" action="{{ route('cart.add') }}">
                                            @csrf
                                            <input type="hidden" name="ticket_id" value="{{ $ticket->ticket_id }}">
                                            <button type="submit" class="card__button"><i
                                                    class="fas fa-cart-plus"></i></button>
                                        </form>
                                    </div>
                                @endauth
                            </div>

                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
