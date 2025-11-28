@extends('layouts.main')

@section('titulo', 'Checkout')
@section('css', '/css/checkout.css')

@section('conteudo')
<div class="checkout-wrapper">
    <div class="checkout-container">
        <h1>Finalizar Compra</h1>
        
        <div class="checkout-layout">
            <!-- Bloco 1: Dados do Pedido -->
            <div class="order-summary-card">
                <h2>Resumo do Pedido</h2>
                
                <div class="order-items">
                    @foreach ($cartItems as $cartItem)
                        <div class="order-item">
                            <div class="item-details">
                                <h3 class="item-name">{{ $cartItem->ticket->event->title }}</h3>
                                <p class="item-date">{{ \Carbon\Carbon::parse($cartItem->ticket->event->start_event_date)->format('d/m/Y') }} às {{ $cartItem->ticket->event->start_event_time }}</p>
                                <p class="item-location">{{ $cartItem->ticket->event->location }}, {{ $cartItem->ticket->event->location_number }}</p>
                                
                            </div>
                            <div class="item-price">
                                R$ {{ number_format($cartItem->ticket->initial_price, 2, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="price-summary">
                    <div class="summary-line">
                        <span>Subtotal:</span>
                        <span>R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                    </div>
                    <div class="summary-line">
                        <span>Taxa TicketPass (5%):</span>
                        <span>R$ {{ number_format($taxa, 2, ',', '.') }}</span>
                    </div>
                    <div class="summary-line total">
                        <span>Total:</span>
                        <span>R$ {{ number_format($total, 2, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Bloco 2: Métodos de Pagamento -->
            <div class="payment-methods-card">
                <h2>Métodos de Pagamento</h2>
                
                <form method="POST" action="{{ route('checkout.process') }}" id="checkout-form">
                    @csrf
                    
                    <div class="payment-methods">
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="pix" required>
                            <div class="payment-card pix">
                                <div class="payment-icon">PIX</div>
                                <div class="payment-info">
                                    <h4>PIX</h4>
                                    <p>Pagamento instantâneo</p>
                                </div>
                            </div>
                        </label>
                        
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="boleto" required>
                            <div class="payment-card boleto">
                                <div class="payment-icon">BOL</div>
                                <div class="payment-info">
                                    <h4>Boleto Bancário</h4>
                                    <p>Vencimento em 1 dia</p>
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- Formulário do Cartão (oculto inicialmente) -->
                    <div id="credit-card-form" class="credit-card-form" style="display: none;">
                        <h3>Dados do Cartão</h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="card_name">Nome no Cartão</label>
                                <input type="text" name="card_name" id="card_name" placeholder="João Silva" class="form-input">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="card_number">Número do Cartão</label>
                                <input type="text" name="card_number" id="card_number" placeholder="1234 5678 9012 3456" maxlength="19" class="form-input">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="card_expiry">Validade</label>
                                <input type="text" name="card_expiry" id="card_expiry" placeholder="MM/AA" maxlength="5" class="form-input">
                            </div>
                            
                            <div class="form-group">
                                <label for="card_cvv">CVV</label>
                                <input type="text" name="card_cvv" id="card_cvv" placeholder="123" maxlength="3" class="form-input">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="checkout-button">
                        Finalizar Compra
                    </button>
                </form>
            </div>
        </div>
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