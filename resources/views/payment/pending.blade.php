@extends('layouts.main')

@section('titulo', 'Pagamento Pendente')
@section('css', '/css/pagamento.css')

@section('conteudo')
<div class="payment-wrapper">
    <div class="container">
        <div class="heading">Pagamento Pendente</div>
        
        <div class="order-summary">
            <h2>Pedido #{{ $order->order_number }}</h2>
            <p class="order-total">Total: R$ {{ number_format($order->total_amount, 2, ',', '.') }}</p>
            <p class="order-status">Status: Aguardando Pagamento</p>
        </div>

        @if($paymentMethod === 'pix')
            <div class="pix-layout">
                <!-- Lado Esquerdo: Informações -->
                <div class="pix-info">
                    <h3>Pagamento via PIX</h3>
                    <div class="instructions">
                        <p>Escaneie o QR Code com o app do seu banco ou use o código copia e cola</p>
                        <p>O pagamento é processado instantaneamente</p>
                        <p>Após o pagamento, você receberá uma confirmação por email</p>
                    </div>
                    
                    <div class="payment-info">
                        <p><strong>Importante:</strong> Após o pagamento, o status será atualizado automaticamente.</p>
                        <p>Você pode fechar esta página. Enviaremos uma confirmação por email.</p>
                    </div>
                </div>
                
                <!-- Lado Direito: QR Code -->
                <div class="pix-qr">
                    @if(isset($paymentData['encodedImage']))
                        <div class="qr-code">
                            <img src="data:image/png;base64,{{ $paymentData['encodedImage'] }}" alt="QR Code PIX">
                        </div>
                    @else
                        <div class="error-message">QR Code não encontrado nos dados</div>
                    @endif
                    
                    @if(isset($paymentData['payload']))
                        <div class="pix-code">
                            <label>Código PIX (Copia e Cola):</label>
                            <div class="code-container">
                                <textarea readonly onclick="this.select()" id="pixCode">{{ $paymentData['payload'] }}</textarea>
                                <button onclick="copyToClipboard('{{ $paymentData['payload'] }}')" class="copy-button">
                                    Copiar Código
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="error-message">Código PIX não encontrado nos dados</div>
                    @endif
                </div>
            </div>
        @endif

        @if($paymentMethod === 'boleto')
            <div class="boleto-layout">
                <div class="boleto-info">
                    <h3>Pagamento via Boleto Bancário</h3>
                    <div class="boleto-details">
                        <p class="due-date">Vencimento: {{ \Carbon\Carbon::parse($paymentData['dueDate'])->format('d/m/Y') }}</p>
                        <p>Valor: R$ {{ number_format($order->total_amount, 2, ',', '.') }}</p>
                    </div>
                    
                    <div class="instructions">
                        <p>Clique no botão abaixo para visualizar e imprimir o boleto</p>
                        <p>O pagamento pode levar até 3 dias úteis para ser processado</p>
                        <p>Após o pagamento, você receberá uma confirmação por email</p>
                    </div>
                </div>
                
                @if(isset($paymentData['bankSlipUrl']))
                    <div class="boleto-action">
                        <a href="{{ $paymentData['bankSlipUrl'] }}" target="_blank" class="login-button">
                            Visualizar Boleto
                        </a>
                    </div>
                @endif
                
                <div class="payment-info">
                    <p><strong>Importante:</strong> Após o pagamento, o status será atualizado automaticamente.</p>
                    <p>Você pode fechar esta página. Enviaremos uma confirmação por email.</p>
                </div>
            </div>
        @endif
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