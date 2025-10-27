@extends('layouts.main')

@section('titulo', 'Pagamento')
@section('css', '/css/pagamento.css')

@section('conteudo')
<div class="container">
    <h1>Pagamento</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="payment-container">
        <div class="order-info">
            <h2>Pedido #{{ $order->order_number }}</h2>
            <p>Total: R$ {{ number_format($order->total_amount, 2, ',', '.') }}</p>
            <p>Status: {{ $order->status }}</p>
        </div>

        <div class="payment-methods">
            <h3>Escolha a forma de pagamento:</h3>
            
            <form method="POST" action="{{ route('payment.process', $order->order_id) }}">
                @csrf
                <div class="payment-options">
                    <label>
                        <input type="radio" name="payment_method" value="credit_card" required>
                        💳 Cartão de Crédito
                    </label>
                    <label>
                        <input type="radio" name="payment_method" value="debit_card" required>
                        💳 Cartão de Débito
                    </label>
                    <label>
                        <input type="radio" name="payment_method" value="pix" required>
                        📱 PIX
                    </label>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-success">Confirmar Pagamento</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection