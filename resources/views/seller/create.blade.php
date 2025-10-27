@extends('layouts.main')

@section('titulo', 'Cadastro de Vendedor')
@section('css', '/css/vendas.css')

@section('conteudo')

    <div class="container">
        <form class="form" method="POST" action="/seller">
            @csrf

            <p class="title">Vendedor</p>
            <p class="message">Faça cadastro para ser um vendedor da TicketPass! </p>
            <label for="cep">
                <input type="text" class="input" name="cep" required>
                <span>Digita seu CEP</span>
            </label>

            <label for="numero">
                <input type="text" class="input" name="house_number" required>
                <span>Digita seu número</span>
            </label>

            <label for="complemento">
                <input type="text" class="input" name="complement" >
                <span>Complemento</span>
            </label>
            
            {{-- <label for="cidade">Cidade:</label>
            <input type="text" class="input" name="cidade" disabled>

            <label for="bairro">Bairro:</label>
            <input type="text" class="input" name="bairro" disabled>

            <label for="rua">Rua:</label>
            <input type="text" class="input" name="complement" disabled> --}}

            <button type="submit" class="submit">Anunciar</button>

        </form>


    </div>

@endsection
