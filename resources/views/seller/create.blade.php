@extends('layouts.main')

@section('titulo', 'Cadastro de Vendedor')
@section('css', '/css/vendas.css')

@section('conteudo')

    <div class="container">
        <form id="salesForm" method="POST" action="/seller">
            @csrf

            <label for="cep">Digita o CEP aí</label>
            <input type="text" id="" name="cep" placeholder="Digite o seu cep" required>
            <label for="numero">Digite o seu número residencial</label>
            <input type="text" id="" name="house_number" placeholder="Número residencial" required>

            <label for="complemento">Digite o complemento se houver</label>
            <input type="text" id="" name="complement" placeholder="Digite o complemento se houver">

            <button type="submit" id="announceButton">Anunciar</button>

        </form>
    </div>

@endsection
