@extends('layouts.main')

@section('titulo', 'Editar Ingresso')
@section('css', '/css/alterar-ingresso.css')

@section('conteudo')
<div class="form-wrapper">
<div class="container">
    <div class="heading">Editar Ingresso</div>
    
    <div class="event-info">
        <h3>{{ $event->title }}</h3>
        <p>{{ \Carbon\Carbon::parse($event->start_event_date)->format('d/m/Y') }}</p>
    </div>
    
    <form action="{{ route('tickets.update', $ticket->ticket_id) }}" method="POST" class="form">
        @csrf
        @method('PUT')
        
        <!-- Informações do Ingresso -->
        <div class="section-title">Dados do Ingresso</div>
    
        
        <input class="input" type="text" name="descricao" id="descricao" placeholder="Descrição do ingresso (Ex: Setor A, Cadeira 15...)" value="{{ $ticket->descricao }}">
        @error('descricao')
            <div class="error">{{ $message }}</div>
        @enderror
        
        <input required class="input" type="number" name="initial_price" id="initial_price" min="0" step="0.01" placeholder="Valor que deseja vender (R$)" value="{{ $ticket->initial_price }}">
        @error('initial_price')
            <div class="error">{{ $message }}</div>
        @enderror
        
        <div class="button-group">
            <input class="login-button" type="submit" value="Atualizar Ingresso">
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