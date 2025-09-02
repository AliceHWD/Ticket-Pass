@extends('layouts.main')

@section('titulo', 'Área de Vendas')
@section('css', '/css/vendas.css')

@section('conteudo')
<div class="container">
    <section>
        <h1>Bem-vindo à área de vendas</h1>
        <p class="vendor-name">(nome do vendedor)</p>
    </section>

    <form id="salesForm">
        <section class="event-data">
            <h2>Dados do evento</h2>
            <div class="autocomplete-container form-group">
                <label for="city">1. Onde seu evento vai acontecer?</label>
                <input type="text" id="city" name="city" placeholder="Digite o nome da cidade..." autocomplete="off" required>
            </div>

            <div class="form-group">
                <label for="eventDate">2. Selecione o dia do evento</label>
                <input type="date" id="eventDate" required>
            </div>
        </section>

        <section class="tickets">
            <h2>Ingressos</h2>
            <div class="form-group">
                <label for="ticketType">3. Selecione o tipo do ingresso</label>
                <select id="ticketType" required>
                    <option value="">Selecione o tipo</option>
                    <option value="tipo1">Inteira</option>
                    <option value="tipo2">Meia</option>
                </select>
            </div>

            <div class="form-group">
                <label for="ticketCategory">4. Categoria do ingresso</label>
                <select id="ticketCategory" required>
                    <option value="">Selecione a categoria</option>
                    <option value="cat1">Categoria 1</option>
                    <option value="cat2">Categoria 2</option>
                </select>
            </div>

            <div class="form-group">
                <label for="ticketQuantity">5. Quantidade de ingressos</label>
                <input type="number" id="ticketQuantity" min="1" required>
            </div>

            <div class="form-group">
                <label for="ticketPrice">6. Valor que deseja vender</label>
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