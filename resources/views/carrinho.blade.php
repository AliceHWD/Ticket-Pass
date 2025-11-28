@extends('layouts.main')

@section('titulo', 'Carrinho')
@section('css', '/css/carrinho.css')

@section('conteudo')
<div class="cart-wrapper">
    <div class="cart-container">
        <h1>Meu Carrinho</h1>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if($cartItems->count() > 0)
            <div class="cart-layout">
                <!-- Bloco 1: Itens do Carrinho -->
                <div class="cart-items-card">
                    <h2>Seus Ingressos</h2>
                    <div class="cart-items" id="cartItems">
                        @foreach($cartItems as $item)
                            <div class="cart-item" data-id="{{ $item->id }}">
                                <div class="item-image"></div>
                                <div class="item-details">
                                    <h3 class="item-name">{{ $item->ticket->event->title }}</h3>
                                    <p class="item-meta"> {{ \Carbon\Carbon::parse($item->ticket->event->start_event_date)->format('d/m/Y') }}</p>
                                    <p class="item-meta"> {{ $item->ticket->event->location }}</p>
                                    
                                    <p class="item-description">{{ $item->ticket->event->description }}</p>
                                </div>
                                <div class="item-actions">
                                    <span class="item-price">R$ {{ number_format($item->ticket->initial_price, 2, ',', '.') }}</span>
                                    <form method="POST" action="{{ route('cart.destroy', $item->id) }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn" onclick="return confirm('Remover item do carrinho?')">
                                             Remover
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Bloco 2: Resumo do Pedido -->
                <div class="order-summary-card">
                    <h2>Resumo do Pedido</h2>
                    
                    {{-- <div class="coupon-section">
                        <input type="text" class="coupon-input" placeholder="Código do cupom">
                        <button class="coupon-btn">Aplicar</button>
                    </div> --}}
                    
                    <div class="summary-details">
                        <div class="summary-line">
                            <span>Subtotal:</span>
                            <span>R$ {{ number_format($cartItems->sum(function($item) { return $item->ticket->initial_price; }), 2, ',', '.') }}</span>
                        </div>
                        <div class="summary-line total">
                            <span>Total:</span>
                            <span id="totalAmount">R$ {{ number_format($cartItems->sum(function($item) { return $item->ticket->initial_price; }), 2, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <a href="{{ route('checkout') }}" class="checkout-button">Finalizar Pedido</a>
                </div>
            </div>
        @else
            <div class="empty-cart">
                <div class="empty-icon">🛒</div>
                <h2>Seu carrinho está vazio</h2>
                <p>Adicione alguns ingressos para continuar</p>
                <a href="/" class="btn btn-primary">Explorar Eventos</a>
            </div>
        @endif
    </div>
</div>


@endsection

@section('js', '/js/carrinho.js')
