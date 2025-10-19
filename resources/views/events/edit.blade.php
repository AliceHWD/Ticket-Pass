@extends('layouts.main')

@section('titulo', 'Editar Evento')
@section('css', '/css/vendas.css')

@section('conteudo')
    <div class="container">
        <section>
            <h1>Editar Evento</h1>
            <p class="vendor-name">{{ Auth::user()->name }}</p>
        </section>

        <form method="POST" action="{{ route('events.update', $event->event_id) }}">
            @csrf
            @method('PUT')
            <section class="event-data">
                <h2>Dados do evento</h2>

                <div class="form-group">
                    <label for="title">Qual o título do evento?</label>
                    <input type="text" id="title" name="title" value="{{ $event->title }}" required>
                </div>

                <div class="form-group">
                    <label for="location">Qual instituição será o evento?</label>
                    <input type="text" id="location" name="location" value="{{ $event->location }}" required>
                </div>

                <div class="form-group">
                    <label for="cep">Qual o cep do evento?</label>
                    <input type="text" id="cep" name="cep" value="{{ $event->cep }}" required>
                </div>

                <div class="form-group">
                    <label for="location_number">Qual o número do local do evento?</label>
                    <input type="number" id="location_number" name="location_number" value="{{ $event->location_number }}" required>
                </div>

                <div class="form-group">
                    <label for="event_date">Data de início do evento</label>
                    <input type="date" name="start_event_date" value="{{ $event->start_event_date }}" required>
                    <input type="time" name="start_event_time" value="{{ $event->start_event_time }}" required>
                </div>

                <div class="form-group">
                    <label for="event_date">Data de fim do evento</label>
                    <input type="date" name="end_event_date" value="{{ $event->end_event_date }}" required>
                    <input type="time" name="end_event_time" value="{{ $event->end_event_time }}" required>
                </div>

                <div class="form-group">
                    <label for="description">Descrição do evento</label>
                    <input type="text" id="description" name="description" value="{{ $event->description }}" required>
                </div>

                <div class="form-group">
                    <label for="category">Categoria do evento</label>
                    <select id="category" name="category" required>
                        <option value="">Selecione a categoria</option>
                        <option value="Festa" {{ $event->category == 'Festa' ? 'selected' : '' }}>Festa</option>
                        <option value="Show" {{ $event->category == 'Show' ? 'selected' : '' }}>Show</option>
                        <option value="Esportes" {{ $event->category == 'Esportes' ? 'selected' : '' }}>Esportes</option>
                        <option value="Palestra" {{ $event->category == 'Palestra' ? 'selected' : '' }}>Palestra</option>
                        <option value="Lazer" {{ $event->category == 'Lazer' ? 'selected' : '' }}>Lazer</option>
                        <option value="Cultura" {{ $event->category == 'Cultura' ? 'selected' : '' }}>Cultura</option>
                        <option value="Outro" {{ $event->category == 'Outro' ? 'selected' : '' }}>Outro</option>
                    </select>
                </div>
            </section>

            <div class="button-container">
                <button type="submit" class="btn btn-primary">Atualizar</button>
                <a href="{{ route('events.show', $event->event_id) }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection