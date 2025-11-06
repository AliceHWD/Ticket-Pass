@extends('layouts.main')

@section('titulo', 'Meus Ingressos')
@section('css', '/css/my-tickets.css')

@section('conteudo')
<div class="container">
    <div class="page-header">
        🎫 Meus Ingressos
    </div>

    @if($confirmedOrders->isEmpty() && $pendingOrders->isEmpty() && $cancelledOrders->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">🎭</div>
            <h3>Nenhum ingresso encontrado</h3>
            <p>Você ainda não comprou nenhum ingresso.</p>
            <a href="/" class="btn btn-primary">Explorar Eventos</a>
        </div>
    @else
        <!-- Ingressos Confirmados -->
        @if($confirmedOrders->isNotEmpty())
            <div class="section">
                <h2 class="section-title confirmed">✅ Ingressos Confirmados</h2>
                <div class="tickets-grid">
                    @foreach($confirmedOrders as $order)
                        @foreach($order->orderItems as $item)
                            @php
                                $event = $item->ticket->event;
                                $isExpired = \Carbon\Carbon::parse($event->start_event_date)->isPast();
                            @endphp
                            <div class="ticket-card confirmed {{ $isExpired ? 'expired' : '' }}">
                                @if($isExpired)
                                    <div class="status-badge expired">Evento Realizado</div>
                                @else
                                    <div class="status-badge confirmed">Confirmado</div>
                                @endif
                                
                                <div class="ticket-content">
                                    <h3>{{ $event->title }}</h3>
                                    <div class="ticket-info">
                                        <p><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($event->start_event_date)->format('d/m/Y') }} às {{ $event->start_event_time }}</p>
                                        <p><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</p>
                                        <p><i class="fas fa-ticket-alt"></i> {{ $item->ticket->code }}</p>
                                        <p><i class="fas fa-money-bill"></i> R$ {{ number_format($item->ticket->initial_price, 2, ',', '.') }}</p>
                                    </div>
                                    
                                    <div class="order-info">
                                        <small>Pedido #{{ $order->order_number }}</small>
                                        <small>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Ingressos Pendentes -->
        @if($pendingOrders->isNotEmpty())
            <div class="section">
                <h2 class="section-title pending">⏳ Pagamentos Pendentes</h2>
                <div class="tickets-grid">
                    @foreach($pendingOrders as $order)
                        @foreach($order->orderItems as $item)
                            @php
                                $event = $item->ticket->event;
                                $paymentMethod = $order->payment->payment_method ?? 'N/A';
                            @endphp
                            <div class="ticket-card pending">
                                <div class="status-badge pending">Aguardando Pagamento</div>
                                
                                <div class="ticket-content">
                                    <h3>{{ $event->title }}</h3>
                                    <div class="ticket-info">
                                        <p><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($event->start_event_date)->format('d/m/Y') }} às {{ $event->start_event_time }}</p>
                                        <p><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</p>
                                        <p><i class="fas fa-credit-card"></i> {{ ucfirst(str_replace('_', ' ', $paymentMethod)) }}</p>
                                        <p><i class="fas fa-money-bill"></i> R$ {{ number_format($item->ticket->initial_price, 2, ',', '.') }}</p>
                                    </div>
                                    
                                    <div class="order-info">
                                        <small>Pedido #{{ $order->order_number }}</small>
                                        <small>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</small>
                                    </div>
                                    
                                    <div class="pending-actions">
                                        <small class="text-warning">
                                            <i class="fas fa-clock"></i> Complete o pagamento para garantir seu ingresso
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Ingressos Cancelados -->
        @if($cancelledOrders->isNotEmpty())
            <div class="section">
                <h2 class="section-title cancelled">❌ Ingressos Cancelados</h2>
                <div class="tickets-grid">
                    @foreach($cancelledOrders as $order)
                        @foreach($order->orderItems as $item)
                            @php
                                $event = $item->ticket->event;
                            @endphp
                            <div class="ticket-card cancelled">
                                <div class="status-badge cancelled">Cancelado</div>
                                
                                <div class="ticket-content">
                                    <h3>{{ $event->title }}</h3>
                                    <div class="ticket-info">
                                        <p><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($event->start_event_date)->format('d/m/Y') }} às {{ $event->start_event_time }}</p>
                                        <p><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</p>
                                        <p><i class="fas fa-money-bill"></i> R$ {{ number_format($item->ticket->initial_price, 2, ',', '.') }}</p>
                                    </div>
                                    
                                    <div class="order-info">
                                        <small>Pedido #{{ $order->order_number }}</small>
                                        <small>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</small>
                                    </div>
                                    
                                    <div class="cancelled-info">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle"></i> Pagamento não foi concluído no prazo
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        @endif
    @endif
</div>
@endsection