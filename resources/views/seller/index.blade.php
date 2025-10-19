@extends('layouts.main')

@section('titulo', 'Meus Eventos')
@section('css', '')

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
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $event->title }}</h5>
                            <p class="card-text">
                                <small class="text-muted">
                                    <i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($event->start_event_date)->format('d/m/Y H:i') }}
                                </small>
                            </p>
                            <p class="card-text">
                                <i class="fas fa-map-marker-alt"></i> {{ $event->location }}
                            </p>
                            <p class="card-text">
                                <strong>A partir de R$ {{ number_format($event->menor_preco, 2, ',', '.') }}</strong>
                            </p>
                            <p class="card-text">
                                <small class="text-muted">{{ $event->total_tickets }} ingressos disponíveis</small>
                            </p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('events.show', $event->event_id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i> Ver Ingressos
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection