@extends('layouts.main')

@section('titulo', 'Pagamento Pendente')
@section('css', '/css/pagamento.css')

@section('conteudo')
    <div class="container">
        <h1>Pagamento Pendente</h1>

        <div class="payment-container">
            <div class="order-info">
                <h2>Pedido #{{ $order->order_number }}</h2>
                <p>Total: R$ {{ number_format($order->total_amount, 2, ',', '.') }}</p>
                <p>Status: Aguardando Pagamento</p>
            </div>

            @if($paymentMethod === 'pix')
                <div class="pix-payment">
                    <h3>Pagamento via PIX</h3>
                    <p>Use o código PIX abaixo para realizar o pagamento:</p>
                    
                    @if(isset($paymentData['qrCode']))
                        <div class="qr-code">
                            <img src="data:image/png;base64,{{ $paymentData['qrCode']['encodedImage'] }}" alt="QR Code PIX">
                        </div>
                    @endif
                    
                    @if(isset($paymentData['pixCopyAndPaste']))
                        <div class="pix-code">
                            <label>Código PIX:</label>
                            <textarea readonly onclick="this.select()">{{ $paymentData['pixCopyAndPaste'] }}</textarea>
                            <button onclick="copyToClipboard('{{ $paymentData['pixCopyAndPaste'] }}')">Copiar Código</button>
                        </div>
                    @endif
                </div>
            @endif

            @if($paymentMethod === 'boleto')
                <div class="boleto-payment">
                    <h3>Pagamento via Boleto</h3>
                    <p>Vencimento: {{ \Carbon\Carbon::parse($paymentData['dueDate'])->format('d/m/Y') }}</p>
                    
                    @if(isset($paymentData['bankSlipUrl']))
                        <a href="{{ $paymentData['bankSlipUrl'] }}" target="_blank" class="btn btn-primary">
                            Visualizar Boleto
                        </a>
                    @endif
                </div>
            @endif

            <div class="payment-info">
                <p><strong>Importante:</strong> Após o pagamento, o status será atualizado automaticamente.</p>
                <p>Você pode fechar esta página. Enviaremos uma confirmação por email.</p>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Código PIX copiado para a área de transferência!');
    });
}
</script>
@endsection