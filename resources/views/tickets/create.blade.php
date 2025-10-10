@extends('layouts.main')

@section('titulo', 'Área de Vendas')
@section('css', '/css/vendas.css')

@section('conteudo')
<div class="container">
    <section>
        <h1>Bem-vindo à área de vendas</h1>
        <p class="vendor-name">{{ Auth::user()->name }}</p>
    </section>

    <form id="salesForm" method="POST" action="/tickets">
        @csrf
        <section class="event-data">
            <h2>Dados do evento</h2>
            <div class="autocomplete-container form-group">
                <label for="title">Qual o título do evento?</label>
                <input type="text" id="title" name="title" placeholder="Digite o título..." autocomplete="off" required>
            </div>

            <div class="autocomplete-container form-group">
                <label for="location">Qual instituição será o evento?</label>
                <input type="text" id="location" name="location" placeholder="BH Hall, Arena MRV..." required>
            </div>

            <div class="autocomplete-container form-group">
                <label for="cep">Qual o cep do evento?</label>
                <input type="text" id="cep" name="cep" placeholder="Digite o cep..." required>
            </div>

            <div class="autocomplete-container form-group">
                <label for="location_number">Qual o número do local do evento?</label>
                <input type="number" id="location_number" name="location_number" placeholder="Digite o número..." required>
            </div>

            <div class="form-group">
                <label for="event_date">Selecione o dia do evento</label>
                <input type="date" id="event_date" required>
            </div>

            <div class="form-group">
                <label for="description">Coloque uma descrição para o evento</label>
                <input type="text" id="description" placeholder="Digite a descrição...">
            </div>

            <div class="form-group">
                <label for="ticketCategory">Categoria do evento</label>
                <select id="ticketCategory" required>
                    <option value="">Selecione a categoria</option>
                    <option value="Festa">Festa</option>
                    <option value="Show">Show</option>
                    <option value="Esportes">Esportes</option>
                    <option value="Palestra">Palestra</option>
                    <option value="Lazer">Lazer</option>
                    <option value="Cultura">Cultura</option>
                    <option value="Outro">Outro</option>
                </select>
            </div>
        </section>

        <section class="tickets">
            <h2>Ingressos</h2>
            <div class="form-group">
                <label for="ticketType">Selecione o tipo do ingresso</label>
                <select id="ticketType" required>
                    <option value="">Selecione o tipo</option>
                    <option value="inteira">Inteira</option>
                    <option value="meia">Meia</option>
                </select>
            </div>

            <div class="form-group">
                <label for="ticketQuantity">Quantidade de ingressos</label>
                <input type="number" id="ticketQuantity" min="1" required>
            </div>

            <div class="form-group">
                <label for="ticketPrice">Valor que deseja vender</label>
                <input type="number" id="ticketPrice" min="0" step="0.01" required>
            </div>

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