@extends('layouts.main')

@section('titulo', 'Histórico de Pagamentos')
@section('css', '/css/historico_pagamento.css')

@section('conteudo')
    <div class="container">
        <h1>Histórico de Pagamentos</h1>

        @if($payments && count($payments) > 0)
            <div class="table-container">
                <table class="payments-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Data</th>
                            <th>Valor</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td class="payment-id">#{{ $payment->payment_id }}</td>
                                <td class="payment-date">
                                    {{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y H:i') }}
                                </td>
                                <td class="payment-amount">
                                    R$ {{ number_format($payment->amount, 2, ',', '.') }}
                                </td>
                                <td class="payment-status">
                                    <span class="status-badge status-{{ $payment->status }}">
                                        @if($payment->status === 'completed')
                                            Realizado
                                        @elseif($payment->status === 'pending')
                                            Pendente
                                        @else
                                            {{ ucfirst($payment->status) }}
                                        @endif
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">💳</div>
                <h3>Nenhum pagamento encontrado</h3>
                <p>Você ainda não realizou nenhum pagamento.</p>
            </div>
        @endif
    </div>
@endsection