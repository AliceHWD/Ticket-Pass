@extends('layouts.main')

@section('titulo', 'Editar Ingresso')
@section('css', '/css/vendas.css')

@section('conteudo')
    <div class="container">
        <section>
            <h1>Editar Ingresso</h1>
            <p class="vendor-name">{{ Auth::user()->name }}</p>
        </section>

        <div class="event-info mb-4">
            <h3>Evento: {{ $event->title }}</h3>
            <p>Data: {{ \Carbon\Carbon::parse($event->start_event_date)->format('d/m/Y') }}</p>
        </div>

        <form method="POST" action="{{ route('tickets.update', $ticket->ticket_id) }}">
            @csrf
            @method('PUT')
            
            <section class="tickets">
                <h2>Dados do Ingresso</h2>

                <div class="form-group">
                    <label for="code">Código do ingresso</label>
                    <input type="text" id="code" name="code" value="{{ $ticket->code }}" required>
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição do ingresso (opcional)</label>
                    <input type="text" id="descricao" name="descricao" value="{{ $ticket->descricao }}" placeholder="Ex: Setor A, Cadeira 15...">
                </div>

                <div class="form-group">
                    <label for="initial_price">Valor que deseja vender</label>
                    <input type="number" id="initial_price" name="initial_price" value="{{ $ticket->initial_price }}" min="0" step="0.01" required>
                </div>
            </section>

            <div class="button-container">
                <button type="submit" class="btn btn-primary">Atualizar</button>
                <a href="{{ route('events.show', $event->event_id) }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection