@extends('layouts.main')

@section('titulo', 'Meus Eventos')
@section('css', '/css/my-events.css')

@section('conteudo')
<div class="container mt-4">
    <h2 class="mb-4">Meus Eventos</h2>
    
    @if($events->isEmpty())
        <div class="alert alert-info">
            <h4>Nenhum evento encontrado</h4>
            <p>Você ainda não possui eventos cadastrados.</p>
        </div>
    @else
        <div class="row">
            @foreach($events as $event)
                @php
                    $isExpired = \Carbon\Carbon::parse($event->start_event_date)->isPast();
                @endphp
                <div class="col-md-4 mb-4">
                    <div class="card h-100 {{ $isExpired ? 'border-danger' : '' }}">
                        @if($isExpired)
                            <div class="card-header bg-danger text-white">
                                <small><i class="fas fa-exclamation-triangle"></i> Evento Expirado</small>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title {{ $isExpired ? 'text-danger' : '' }}">{{ $event->title }}</h5>
                            <p class="card-text">
                                <small class="{{ $isExpired ? 'text-danger' : 'text-muted' }}">
                                    <i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($event->start_event_date)->format('d/m/Y H:i') }}
                                </small>
                            </p>
                            <p class="card-text">
                                <i class="fas fa-map-marker-alt"></i> {{ $event->location }}
                            </p>
                            @if($event->tickets_min_initial_price)
                                <p class="card-text">
                                    <strong>A partir de R$ {{ number_format($event->tickets_min_initial_price, 2, ',', '.') }}</strong>
                                </p>
                            @else
                                <p class="card-text text-warning">
                                    <strong><i class="fas fa-exclamation-circle"></i> Sem ingressos cadastrados</strong>
                                </p>
                            @endif
                            <p class="card-text">
                                <small class="text-muted">{{ $event->total_tickets }} ingressos disponíveis</small>
                            </p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('events.show', $event->event_id) }}" class="btn {{ $isExpired ? 'btn-outline-danger' : 'btn-primary' }} btn-sm">
                                <i class="fas fa-eye"></i> Ver Ingressos
                            </a>
                            @if($isExpired)
                                <small class="text-danger d-block mt-1">
                                    <i class="fas fa-ban"></i> Fora do período de venda
                                </small>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection