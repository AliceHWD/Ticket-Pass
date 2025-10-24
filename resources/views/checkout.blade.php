@extends('layouts.main')

@section('titulo', 'Carrinho')
@section('css', '/css/checkout.css')

@section('conteudo')
<form method="POST" action="{{ route('checkout.process') }}">
    @csrf
    <div class="page-header">
        💳 Finalizar Pagamento
    </div>
    @foreach ($cartItems as $cartItem)
        <div class="order-item">
            <h3>{{ $cartItem->ticket->event->title }}</h3>
            <p>Início: {{ \Carbon\Carbon::parse($cartItem->ticket->event->start_event_date)->format('d/m/Y') }} às {{ $cartItem->ticket->event->start_event_time }}</p>
            <p>Fim: {{ \Carbon\Carbon::parse($cartItem->ticket->event->end_event_date)->format('d/m/Y') }} às {{ $cartItem->ticket->event->end_event_time }}</p>
            <p>Local: {{ $cartItem->ticket->event->location }}, {{ $cartItem->ticket->event->location_number }}</p>
            <p>CEP: {{ $cartItem->ticket->event->cep }}</p>
            <p>Categoria: {{ $cartItem->ticket->event->category }}</p>
            @if($cartItem->ticket->event->description)
                <p>Descrição do Evento: {{ $cartItem->ticket->event->description }}</p>
            @endif
            
            <p><strong>Código do Ingresso:</strong> {{ $cartItem->ticket->code }}</p>
            @if($cartItem->ticket->descricao)
                <p><strong>Detalhes do Ingresso:</strong> {{ $cartItem->ticket->descricao }}</p>
            @endif
            <p><strong>Preço:</strong> R$ {{ number_format($cartItem->ticket->initial_price, 2, ',', '.') }}</p>
        </div>
    @endforeach
    <hr>
    <div class="price-summary">
        <p><strong>Subtotal:</strong> R$ {{ number_format($subtotal, 2, ',', '.') }}</p>
        <p><strong>Taxa TicketPass (5%):</strong> R$ {{ number_format($taxa, 2, ',', '.') }}</p>
        <p id="total"><strong>Total:</strong> R$ {{ number_format($total, 2, ',', '.') }}</p>
        <button type="submit">
            Prosseguir para o pagamento
        </button>
    </div>
</form>
@endsection