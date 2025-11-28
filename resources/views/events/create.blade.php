@extends('layouts.main')

@section('titulo', 'Criar Evento')
@section('css', '/css/vendas.css')

@section('conteudo')
<div class="form-wrapper">
<div class="container">
    <div class="heading">Criar Evento</div>
    <form action="/events" method="POST" class="form">
        @csrf
        
        <!-- Informações Básicas -->
        <div class="section-title">Informações do Evento</div>
        
        <input required class="input" type="text" name="title" id="title" placeholder="Título do evento" value="{{ old('title') }}">
        @error('title')
            <div class="error">{{ $message }}</div>
        @enderror
        
        <textarea required class="input" name="description" id="description" placeholder="Descrição do evento">{{ old('description') }}</textarea>
        @error('description')
            <div class="error">{{ $message }}</div>
        @enderror
        
        <select required class="input" name="category" id="category">
            <option value="">Selecione a categoria</option>
            <option value="Festa" {{ old('category') == 'Festa' ? 'selected' : '' }}>Festa</option>
            <option value="Show" {{ old('category') == 'Show' ? 'selected' : '' }}>Show</option>
            <option value="Esportes" {{ old('category') == 'Esportes' ? 'selected' : '' }}>Esportes</option>
            <option value="Palestra" {{ old('category') == 'Palestra' ? 'selected' : '' }}>Palestra</option>
            <option value="Lazer" {{ old('category') == 'Lazer' ? 'selected' : '' }}>Lazer</option>
            <option value="Cultura" {{ old('category') == 'Cultura' ? 'selected' : '' }}>Cultura</option>
            <option value="Outro" {{ old('category') == 'Outro' ? 'selected' : '' }}>Outro</option>
        </select>
        @error('category')
            <div class="error">{{ $message }}</div>
        @enderror
        
        <!-- Local do Evento -->
        <div class="section-title">Local do Evento</div>
        
        <input required class="input" type="text" name="location" id="location" placeholder="Local (BH Hall, Arena MRV...)" value="{{ old('location') }}">
        @error('location')
            <div class="error">{{ $message }}</div>
        @enderror
        
        <input required class="input" type="text" name="cep" id="cep" placeholder="CEP do evento" value="{{ old('cep') }}">
        @error('cep')
            <div class="error">{{ $message }}</div>
        @enderror
        
        <input required class="input" type="number" name="location_number" id="location_number" placeholder="Número do local" value="{{ old('location_number') }}">
        @error('location_number')
            <div class="error">{{ $message }}</div>
        @enderror
        
        <!-- Data e Horário -->
        <div class="section-title">Data e Horário</div>
        
        <div class="datetime-row">
            <div class="datetime-group">
                <input required class="input datetime-input" type="date" name="start_event_date" id="start_event_date" value="{{ old('start_event_date') }}">
                <input required class="input datetime-input" type="time" name="start_event_time" id="start_event_time" value="{{ old('start_event_time') }}">
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
                <input required class="input datetime-input" type="date" name="end_event_date" id="end_event_date" value="{{ old('end_event_date') }}">
                <input required class="input datetime-input" type="time" name="end_event_time" id="end_event_time" value="{{ old('end_event_time') }}">
            </div>
        </div>
        @error('end_event_date')
            <div class="error">{{ $message }}</div>
        @enderror
        @error('end_event_time')
            <div class="error">{{ $message }}</div>
        @enderror
        
        <input class="login-button" type="submit" value="Criar Evento">
    </form>
    
    <div class="social-account-container">
        <span class="title">Área de Vendas</span>
    </div>
    <span class="agreement"><a href="#">Vendedor: {{ Auth::user()->name }}</a></span>
</div>
</div>
@endsection
