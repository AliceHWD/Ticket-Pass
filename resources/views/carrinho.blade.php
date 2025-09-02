@extends('layouts.main')

@section('titulo', 'Carrinho')
@section('css', '/css/carrinho.css')

@section('conteudo')
<div id="app">
    <div class="cart-container">
        <h1>Meu Carrinho</h1>
        <div class="cart-items" id="cartItems">
            <!-- Cart items will be dynamically added here -->
        </div>
        <div class="cart-total">
            <span class="total-label">Total:</span>
            <span class="total-amount" id="totalAmount">R$00</span>
        </div>
        <button class="checkout-button">Finalizar Compra</button>
    </div>
</div>

<div class="footer-mob">

    <div class="container-buttons">
        <div class="inicio">
            <a href="./index.php">
                <i class="fa-solid fa-house"></i>
                Início
            </a>
        </div>
        <div class="anunciar">
            <a href="./areaV.php">
                <i class="fa-solid fa-plus"></i>
                Anunciar
            </a>
        </div>
        <div class="procura">
            <a href="./pesquisa.php">
                <i class="fa-solid fa-globe"></i>
                Procurar
            </a>
        </div>
        <div class="ingressos">
            <a href="./ingressoM.php">
                <i class="fa-solid fa-ticket"></i>
                Ingressos
            </a>
        </div>
        <div class="carrinho-footer">
            <a href="./cart.php">
                <i class="fa-solid fa-cart-shopping"></i>
                Carrinho
            </a>
        </div>
        <div class="perfil-mob">
            <a href="./perfil/perfil.php">
                <i class="fa-solid fa-user"></i>
                Perfil
            </a>
        </div>
    </div>

</div>
@endsection

@section('js', '/js/carrinho.js')