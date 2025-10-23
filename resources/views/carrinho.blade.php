@extends('layouts.main')

@section('titulo', 'Carrinho')
@section('css', '/css/carrinho.css')

@section('conteudo')
    <div id="app">
        <div class="cart-container">
            <h1>Meu Carrinho</h1>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="cart-items" id="cartItems">
                @forelse($cartItems as $item)
                    <div class="cart-item" data-id="{{ $item->id }}">
                        <div class="item-image"></div>
                        <div class="item-details">
                            <h3 class="item-name">{{ $item->ticket->event->title }}</h3>
                            <p class="item-meta">{{ \Carbon\Carbon::parse($item->ticket->event->start_event_date)->format('d/m/Y') }} - {{ $item->ticket->event->location }}</p>
                            <p class="ticket-code">Código: {{ $item->ticket->code }}</p>

                        </div>
                        <span class="item-price">R$ {{ number_format($item->ticket->initial_price, 2, ',', '.') }}</span>
                        <form method="POST" action="{{ route('cart.destroy', $item->id) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn" onclick="return confirm('Remover item do carrinho?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="empty-cart">
                        <p>Seu carrinho está vazio</p>
                        <a href="/" class="btn btn-primary">Continuar Comprando</a>
                    </div>
                @endforelse
            </div>
            <div class="cart-total">
                <span class="total-label">Total:</span>
                <span class="total-amount" id="totalAmount">R$ {{ number_format($cartItems->sum(function($item) { return $item->ticket->initial_price; }), 2, ',', '.') }}</span>
            </div>
            @if($cartItems->count() > 0)
                <a href="{{ route('checkout') }}" class="checkout-button">Finalizar Compra</a>
            @endif
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
