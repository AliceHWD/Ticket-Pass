@extends('layouts.main')

@section('titulo', 'Meus Ingressos')
@section('css', '/css/my-tickets.css')

@section('conteudo')
<div class="tickets-wrapper">
    <div class="container">
        <div class="heading">Meus Ingressos</div>

        @if($confirmedOrders->isEmpty() && $pendingOrders->isEmpty() && $cancelledOrders->isEmpty())
            <div class="empty-state">
                <div class="empty-icon"></div>
                <h3>Nenhum ingresso encontrado</h3>
                <p>Você ainda não comprou nenhum ingresso.</p>
                <a href="/" class="login-button">Explorar Eventos</a>
            </div>
        @else
            <!-- Ingressos Confirmados -->
            @if($confirmedOrders->isNotEmpty())
                <div class="section">
                    <h2 class="section-title confirmed">Ingressos Confirmados</h2>
                    <div class="tickets-grid">
                        @foreach($confirmedOrders as $order)
                            @foreach($order->orderItems as $item)
                                @php
                                    $event = $item->ticket->event;
                                    $isExpired = \Carbon\Carbon::parse($event->start_event_date)->isPast();
                                @endphp
                                <div class="card">
                                    <div class="card__shine"></div>
                                    <div class="card__glow"></div>
                                    <div class="card__content">
                                        <div class="card__badge">{{ $isExpired ? 'USADO' : 'ATIVO' }}</div>
                                        <div style="--bg-color: #10b981" class="card__image"></div>
                                        <div class="card__text">
                                            <p class="card__title">{{ $event->title }}</p>
                                            <p class="card__description">{{ \Carbon\Carbon::parse($event->start_event_date)->format('d/m/Y') }}</p>
                                        </div>
                                        <div class="card__footer">
                                            <div class="card__price">R$ {{ number_format($item->ticket->initial_price, 2, ',', '.') }}</div>
                                            <div class="card__button">
                                                <svg height="16" width="16" viewBox="0 0 24 24">
                                                    <path stroke-width="2" stroke="currentColor" d="M4 12H20M12 4V20" fill="currentColor"></path>
                                                </svg>
                                            </div>
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
                    <h2 class="section-title pending">Pagamentos Pendentes</h2>
                    <div class="tickets-grid">
                        @foreach($pendingOrders as $order)
                            @foreach($order->orderItems as $item)
                                @php
                                    $event = $item->ticket->event;
                                    $paymentMethod = $order->payment->payment_method ?? 'N/A';
                                @endphp
                                <div class="card pending">
                                    <div class="card__shine"></div>
                                    <div class="card__glow"></div>
                                    <div class="card__content">
                                        <div class="card__badge">PENDENTE</div>
                                        <div style="--bg-color: #f59e0b" class="card__image"></div>
                                        <div class="card__text">
                                            <p class="card__title">{{ $event->title }}</p>
                                            <p class="card__description">{{ \Carbon\Carbon::parse($event->start_event_date)->format('d/m/Y') }}</p>
                                        </div>
                                        <div class="card__footer">
                                            <div class="card__price">R$ {{ number_format($item->ticket->initial_price, 2, ',', '.') }}</div>
                                            <div class="card__button">
                                                <svg height="16" width="16" viewBox="0 0 24 24">
                                                    <path stroke-width="2" stroke="currentColor" d="M12 6V12L16 14" fill="none"></path>
                                                </svg>
                                            </div>
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
                    <h2 class="section-title cancelled">Ingressos Cancelados</h2>
                    <div class="tickets-grid">
                        @foreach($cancelledOrders as $order)
                            @foreach($order->orderItems as $item)
                                @php
                                    $event = $item->ticket->event;
                                @endphp
                                <div class="card cancelled">
                                    <div class="card__shine"></div>
                                    <div class="card__glow"></div>
                                    <div class="card__content">
                                        <div class="card__badge">CANCELADO</div>
                                        <div style="--bg-color: #ef4444" class="card__image"></div>
                                        <div class="card__text">
                                            <p class="card__title">{{ $event->title }}</p>
                                            <p class="card__description">{{ \Carbon\Carbon::parse($event->start_event_date)->format('d/m/Y') }}</p>
                                        </div>
                                        <div class="card__footer">
                                            <div class="card__price">R$ {{ number_format($item->ticket->initial_price, 2, ',', '.') }}</div>
                                            <div class="card__button">
                                                <svg height="16" width="16" viewBox="0 0 24 24">
                                                    <path stroke-width="2" stroke="currentColor" d="M6 18L18 6M6 6L18 18" fill="none"></path>
                                                </svg>
                                            </div>
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
</div>
@endsection