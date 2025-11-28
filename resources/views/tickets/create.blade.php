@extends('layouts.main')

@section('titulo', 'Criar Ingresso')
@section('css', '/css/vendas-ingresso.css')

@section('conteudo')
<div class="form-wrapper">
<div class="container">
    <div class="heading">Criar Ingresso</div>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="/tickets" method="POST" class="form">
        @csrf
        
        <!-- Informações do Evento -->
        <div class="section-title">Informações do Ingresso</div>
        
        @if ($eventId)
            <input type="hidden" name="event_id" value="{{ $eventId }}">
        @else
            <select required class="input" name="event_id" id="event_id">
                <option value="">Selecione o evento</option>
                @foreach ($events as $event)
                    <option value="{{ $event->event_id }}" {{ old('event_id') == $event->event_id ? 'selected' : '' }}>{{ $event->title }}</option>
                @endforeach
            </select>
            @error('event_id')
                <div class="error">{{ $message }}</div>
            @enderror
        @endif
        
        <input class="input" type="text" name="descricao" id="descricao" placeholder="Descrição do ingresso (Ex: Setor A, Cadeira 15...)" value="{{ old('descricao') }}">
        @error('descricao')
            <div class="error">{{ $message }}</div>
        @enderror
        
        <!-- Preço e Quantidade -->
        <div class="section-title">Preço e Quantidade</div>
        
        <input required class="input" type="number" name="initial_price" id="initial_price" min="0" step="0.01" placeholder="Valor que deseja vender (R$)" value="{{ old('initial_price') }}">
        @error('initial_price')
            <div class="error">{{ $message }}</div>
        @enderror
        
        <input required class="input" type="number" name="ticketQuantity" id="ticketQuantity" min="1" placeholder="Quantidade de ingressos" value="{{ old('ticketQuantity') }}">
        @error('ticketQuantity')
            <div class="error">{{ $message }}</div>
        @enderror
        

        
        <div class="total-display">
            <span>Total a receber: R$ <span id="totalAmount">0.00</span></span>
        </div>
        
        <input class="login-button" type="submit" value="Anunciar Ingresso">
    </form>
    
    <div class="social-account-container">
        <span class="title">Área de Vendas</span>
    </div>
    <span class="agreement"><a href="#">Vendedor: {{ Auth::user()->name }}</a></span>
</div>
</div>
@endsection

@section('js', '/js/criar-ingresso.js')