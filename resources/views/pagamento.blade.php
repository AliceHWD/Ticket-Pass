@extends('layouts.main')

@section('titulo', 'Pagamento')
@section('css', '/css/pagamento.css')

@section('conteudo')
<section>

    <h1>Pagamento</h1>
    <div class="container">
        <h4>Selecione a forma de pagamento</h4>
        <p>Valor: R$125.00</p>
        <div class="payment-methods">
            <label>
                <input type="radio" name="payment-method" value="credit" id="credit-radio"> Crédito
            </label>
            <label>
                <input type="radio" name="payment-method" value="pix" id="pix-radio"> PIX
            </label>
        </div>

        <div class="linha"></div>

        <!-- Credit Card Form -->
        <div class="form-container" id="credit-form">
            <button class="add-cartao" id="add-card-button">
                <i class="fa-solid fa-circle-plus"></i>
                Adicionar Cartão
            </button>

            <div class="form-section">
                <div class="form-group">
                    <label for="card-number">Número do Cartão</label>
                    <input type="text" id="card-number" maxlength="19" placeholder="1234 5678 9012 3456">
                </div>
                <div class="form-group">
                    <label for="card-name">Nome</label>
                    <input type="text" id="card-name" placeholder="João Silva">
                </div>
                <div class="form-group">
                    <label for="card-expiry">Data de Validade</label>
                    <input type="text" id="card-expiry" placeholder="MM/AA">
                </div>
                <div class="form-group">
                    <label for="card-cvv">CVV</label>
                    <input type="text" id="card-cvv" maxlength="3" placeholder="123">
                </div>
                <button class="btn" id="save-card-button">Adicionar cartão</button>
            </div>
            <div class="card-section">
                <div class="card">
                    <div class="number">#### #### #### ####</div>
                    <div class="name">NOME</div>
                    <div class="expiry">MM/YY</div>
                    <div class="cvv">CVV: ###</div>
                </div>
            </div>
        </div>

        <div id="saved-cards"></div>
        <!-- PIX Form -->
        <div class="pix-container" id="pix-form">
            <h2>Pagamento com QR-code</h2>
            <div class="pix-qr">
                <img src="./imagens/teste.png" alt="QR Code">
            </div>
            <div class="pix-code">
                <input type="text" id="pix-copy-code" readonly value="123e4567-e89b-12d3-a456-426614174000">
                <button id="copy-pix-button">Copiar</but>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js', '/js/pagamento.js')