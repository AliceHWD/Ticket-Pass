@extends('layouts.main')

@section('titulo', 'Área de Vendas')
@section('css', '/css/vendas.css')

@section('conteudo')
    <div class="container">
        <section>
            <h1>Bem-vindo à área de vendas</h1>
            <p class="vendor-name">{{ Auth::user()->name }}</p>
        </section>

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

        <form id="salesForm" method="POST" action="/tickets">
            @csrf
            <section class="tickets">
                <h2>Ingressos</h2>

                @if ($eventId)
                    <div class="form-group">
                        <input type="hidden" id="event_id" name="event_id" value="{{ $eventId }}">
                    </div>
                @else
                    <div class="form-group">
                        <label for="event_id">Selecione o evento</label>
                        <select id="event_id" name="event_id" required>
                            <option value="">Selecione o evento</option>
                            @foreach ($events as $event)
                                <option value="{{ $event->event_id }}">{{ $event->title }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="form-group">
                    <label for="descricao">Descreva os dados do ingresso (opcional)</label>
                    <input type="text" id="descricao" name="descricao" placeholder="Ex: Setor A, Cadeira 15...">
                </div>

                <div class="form-group">
                    <label for="initial_price">Valor que deseja vender</label>
                    <input type="number" id="initial_price" name="initial_price" min="0" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="ticketQuantity">Quantidade de ingressos</label>
                    <input type="number" id="ticketQuantity" min="1" required>
                </div>

                <div id="ticketCodesContainer"></div>

                <div class="total">
                    <p>Total a receber: R$<span id="totalAmount">0.00</span></p>
                </div>
            </section>

            <div class="button-container">
                <button type="submit" id="announceButton">Anunciar</button>
            </div>
        </form>
    </div>

@endsection

@section('js', '/js/criar-ingresso.js')