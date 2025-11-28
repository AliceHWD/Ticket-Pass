@extends('layouts.main')

@section('titulo', 'Editar Evento')
@section('css', '/css/alterar-evento.css')

@section('conteudo')
<div class="form-wrapper">
<div class="container">
    <div class="heading">Editar Evento</div>
    <form action="{{ route('events.update', $event->event_id) }}" method="POST" class="form">
        @csrf
        @method('PUT')
        
        <!-- Informações Básicas -->
        <div class="section-title">Informações do Evento</div>
        
        <input required class="input" type="text" name="title" id="title" placeholder="Título do evento" value="{{ $event->title }}">
        @error('title')
            <div class="error">{{ $message }}</div>
        @enderror
        
        <textarea required class="input" name="description" id="description" placeholder="Descrição do evento">{{ $event->description }}</textarea>
        @error('description')
            <div class="error">{{ $message }}</div>
        @enderror
        
        <select required class="input" name="category" id="category">
            <option value="">Selecione a categoria</option>
            <option value="Festa" {{ $event->category == 'Festa' ? 'selected' : '' }}>Festa</option>
            <option value="Show" {{ $event->category == 'Show' ? 'selected' : '' }}>Show</option>
            <option value="Esportes" {{ $event->category == 'Esportes' ? 'selected' : '' }}>Esportes</option>
            <option value="Palestra" {{ $event->category == 'Palestra' ? 'selected' : '' }}>Palestra</option>
            <option value="Lazer" {{ $event->category == 'Lazer' ? 'selected' : '' }}>Lazer</option>
            <option value="Cultura" {{ $event->category == 'Cultura' ? 'selected' : '' }}>Cultura</option>
            <option value="Outro" {{ $event->category == 'Outro' ? 'selected' : '' }}>Outro</option>
        </select>
        @error('category')
            <div class="error">{{ $message }}</div>
        @enderror
        
        <!-- Local do Evento -->
        <div class="section-title">Local do Evento</div>
        
        <input required class="input" type="text" name="location" id="location" placeholder="Local (BH Hall, Arena MRV...)" value="{{ $event->location }}">
        @error('location')
            <div class="error">{{ $message }}</div>
        @enderror
        
        <input required class="input" type="text" name="cep" id="cep" placeholder="CEP do evento" value="{{ $event->cep }}">
        @error('cep')
            <div class="error">{{ $message }}</div>
        @enderror
        
        <input required class="input" type="number" name="location_number" id="location_number" placeholder="Número do local" value="{{ $event->location_number }}">
        @error('location_number')
            <div class="error">{{ $message }}</div>
        @enderror
        
        <!-- Data e Horário -->
        <div class="section-title">Data e Horário</div>
        
        <div class="datetime-row">
            <div class="datetime-group">
                <input required class="input datetime-input" type="date" name="start_event_date" id="start_event_date" value="{{ $event->start_event_date }}">
                <input required class="input datetime-input" type="time" name="start_event_time" id="start_event_time" value="{{ $event->start_event_time }}">
            </div>
        </div>
        @error('start_event_date')
            <div class="error">{{ $message }}</div>
        @enderror
        @error('start_event_time')
            <div class="error">{{ $message }}</div>
        @enderror
        
        <div class="datetime-row">
            <div class="datetime-group">
                <input required class="input datetime-input" type="date" name="end_event_date" id="end_event_date" value="{{ $event->end_event_date }}">
                <input required class="input datetime-input" type="time" name="end_event_time" id="end_event_time" value="{{ $event->end_event_time }}">
            </div>
        </div>
        @error('end_event_date')
            <div class="error">{{ $message }}</div>
        @enderror
        @error('end_event_time')
            <div class="error">{{ $message }}</div>
        @enderror
        
        <div class="button-group">
            <input class="login-button" type="submit" value="Atualizar Evento">
            <a href="{{ route('events.show', $event->event_id) }}" class="cancel-button">Cancelar</a>
        </div>
    </form>
    
    <div class="social-account-container">
        <span class="title">Área de Vendas</span>
    </div>
    <span class="agreement"><a href="#">Vendedor: {{ Auth::user()->name }}</a></span>
</div>
</div>
@endsection