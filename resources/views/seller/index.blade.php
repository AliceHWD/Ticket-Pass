@extends('layouts.main')

@section('titulo', 'Meus Eventos')
@section('css', '/css/my-events.css')

@section('conteudo')
<div class="events-wrapper">
    <div class="container">
        <div class="heading">Meus Eventos</div>
        
        @if($events->isEmpty())
            <div class="empty-state">
                <div class="empty-icon"></div>
                <h3>Nenhum evento encontrado</h3>
                <p>Você ainda não possui eventos cadastrados.</p>
                <a href="{{ route('events.create') }}" class="login-button">Criar Primeiro Evento</a>
            </div>
        @else
            <div class="events-grid">
                @foreach($events as $event)
                    @php
                        $isExpired = \Carbon\Carbon::parse($event->start_event_date)->isPast();
                    @endphp
                    <div class="event-card {{ $isExpired ? 'expired' : '' }}">
                        @if($isExpired)
                            <div class="status-badge expired">
                                Evento Expirado
                            </div>
                        @else
                            <div class="status-badge active">
                                Ativo
                            </div>
                        @endif
                        
                        <div class="event-content">
                            <h3 class="event-title">{{ $event->title }}</h3>
                            
                            <div class="event-info">
                                <p class="event-date">
                                    {{ \Carbon\Carbon::parse($event->start_event_date)->format('d/m/Y H:i') }}
                                </p>
                                <p class="event-location">
                                    {{ $event->location }}
                                </p>
                                
                                @if($event->tickets_min_initial_price)
                                    <p class="event-price">
                                        A partir de R$ {{ number_format($event->tickets_min_initial_price, 2, ',', '.') }}
                                    </p>
                                @else
                                    <p class="event-warning">
                                        Sem ingressos cadastrados
                                    </p>
                                @endif
                                
                                <p class="event-tickets">
                                    {{ $event->total_tickets }} ingressos disponíveis
                                </p>
                            </div>
                        </div>
                        
                        <div class="event-actions">
                            <a href="{{ route('events.show', $event->event_id) }}" class="login-button {{ $isExpired ? 'disabled' : '' }}">
                                Ver Ingressos
                            </a>
                            @if($isExpired)
                                <small class="expired-notice">
                                    Fora do período de venda
                                </small>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection