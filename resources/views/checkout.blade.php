@extends('layouts.main')

@section('titulo', 'Checkout')
@section('css', '/css/checkout.css')

@section('conteudo')
<div class="page-header">
    💳 Finalizar Compra
</div>

<div class="checkout-container">
    <!-- Resumo do Pedido -->
    <div class="order-summary">
        <h2>Resumo do Pedido</h2>
        @foreach ($cartItems as $cartItem)
            <div class="order-item">
                <h3>{{ $cartItem->ticket->event->title }}</h3>
                <p>📅 {{ \Carbon\Carbon::parse($cartItem->ticket->event->start_event_date)->format('d/m/Y') }} às {{ $cartItem->ticket->event->start_event_time }}</p>
                <p>📍 {{ $cartItem->ticket->event->location }}, {{ $cartItem->ticket->event->location_number }}</p>
                <p><strong>Ingresso:</strong> {{ $cartItem->ticket->code }}</p>
                <p><strong>Preço:</strong> R$ {{ number_format($cartItem->ticket->initial_price, 2, ',', '.') }}</p>
            </div>
        @endforeach
        
        <div class="price-summary">
            <p><strong>Subtotal:</strong> R$ {{ number_format($subtotal, 2, ',', '.') }}</p>
            <p><strong>Taxa TicketPass (5%):</strong> R$ {{ number_format($taxa, 2, ',', '.') }}</p>
            <p class="total"><strong>Total:</strong> R$ {{ number_format($total, 2, ',', '.') }}</p>
        </div>
    </div>

    <!-- Forma de Pagamento -->
    <div class="payment-section">
        <h2>Forma de Pagamento</h2>
        
        <form method="POST" action="{{ route('checkout.process') }}" id="checkout-form">
            @csrf
            
            <div class="payment-methods">
                <label class="payment-option">
                    <input type="radio" name="payment_method" value="pix" required>
                    <span>📱 PIX</span>
                </label>
                
                <label class="payment-option">
                    <input type="radio" name="payment_method" value="boleto" required>
                    <span>🧾 Boleto Bancário</span>
                </label>
                
                <label class="payment-option">
                    <input type="radio" name="payment_method" value="credit_card" required>
                    <span>💳 Cartão de Crédito</span>
                </label>
            </div>

            <!-- Formulário do Cartão (oculto inicialmente) -->
            <div id="credit-card-form" class="credit-card-form" style="display: none;">
                <h3>Dados do Cartão</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="card_name">Nome no Cartão</label>
                        <input type="text" name="card_name" id="card_name" placeholder="João Silva">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="card_number">Número do Cartão</label>
                        <input type="text" name="card_number" id="card_number" placeholder="1234 5678 9012 3456" maxlength="19">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="card_expiry">Validade</label>
                        <input type="text" name="card_expiry" id="card_expiry" placeholder="MM/AA" maxlength="5">
                    </div>
                    
                    <div class="form-group">
                        <label for="card_cvv">CVV</label>
                        <input type="text" name="card_cvv" id="card_cvv" placeholder="123" maxlength="3">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-finalizar">
                Finalizar Compra
            </button>
        </form>
    </div>
</div>

<script>
// Mostrar/ocultar formulário do cartão
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const creditCardForm = document.getElementById('credit-card-form');
    
    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            if (this.value === 'credit_card') {
                creditCardForm.style.display = 'block';
                // Tornar campos obrigatórios
                document.getElementById('card_name').required = true;
                document.getElementById('card_number').required = true;
                document.getElementById('card_expiry').required = true;
                document.getElementById('card_cvv').required = true;
            } else {
                creditCardForm.style.display = 'none';
                // Remover obrigatoriedade
                document.getElementById('card_name').required = false;
                document.getElementById('card_number').required = false;
                document.getElementById('card_expiry').required = false;
                document.getElementById('card_cvv').required = false;
            }
        });
    });
    
    // Formatação do número do cartão
    document.getElementById('card_number').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
        e.target.value = value;
    });
    
    // Formatação da data de validade
    document.getElementById('card_expiry').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }
        e.target.value = value;
    });
});
</script>
@endsection