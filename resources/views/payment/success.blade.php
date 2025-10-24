@extends('layouts.main')

@section('titulo', 'Pagamento Confirmado')
@section('css', '/css/payment.css')

@section('conteudo')
<div class="container">
    <div class="success-container">
        <div class="success-icon">
            ✅
        </div>
        
        <h1>Pagamento Confirmado!</h1>
        
        <div class="order-details">
            <h2>Pedido #{{ $order->order_number }}</h2>
            <p>Valor pago: R$ {{ number_format($order->total_amount, 2, ',', '.') }}</p>
            <p>Forma de pagamento: {{ $paymentMethod }}</p>
            <p>Data: {{ now()->format('d/m/Y H:i') }}</p>
        </div>

        <div class="next-steps">
            <h3>Próximos passos:</h3>
            <ul>
                <li>Seus ingressos foram confirmados</li>
                <li>Você receberá um e-mail com os detalhes</li>
                <li>Apresente o código do ingresso no evento</li>
            </ul>
        </div>

        <div class="actions">
            <a href="/" class="btn btn-primary">Voltar ao Início</a>
            <a href="/my-tickets" class="btn btn-secondary">Meus Ingressos</a>
        </div>
    </div>
</div>
@endsection