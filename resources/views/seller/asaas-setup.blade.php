@extends('layouts.main')

@section('titulo', 'Configurar Asaas')

@section('conteudo')
<div class="container">
    <h1>Configuração Asaas</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('info'))
        <div class="alert alert-info">
            {{ session('info') }}
        </div>
    @endif

    @if($seller && $seller->asaas_account_id)
        <div class="alert alert-success">
            <h4>✅ Subconta Asaas Configurada</h4>
            <p><strong>Account ID:</strong> {{ $seller->asaas_account_id }}</p>
            <p><strong>Wallet ID:</strong> {{ $seller->asaas_wallet_id }}</p>
            <p>Você já pode receber pagamentos com split automático!</p>
        </div>
    @else
        <div class="alert alert-warning">
            <h4>⚠️ Configuração Necessária</h4>
            <p>Para receber pagamentos, você precisa criar uma subconta no Asaas.</p>
        </div>

        <form method="POST" action="{{ route('seller.asaas.create') }}">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Nome Completo</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', Auth::user()->name) }}" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cpf">CPF (apenas números)</label>
                        <input type="text" name="cpf" id="cpf" class="form-control" maxlength="11" placeholder="12345678901" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone">Telefone</label>
                        <input type="text" name="phone" id="phone" class="form-control" placeholder="11999999999" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="birth_date">Data de Nascimento</label>
                        <input type="date" name="birth_date" id="birth_date" class="form-control" required>
                    </div>
                </div>
            </div>

            <h4>Endereço</h4>
            
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="address">Endereço</label>
                        <input type="text" name="address" id="address" class="form-control" placeholder="Rua Exemplo, 123" required>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="address_number">Número</label>
                        <input type="text" name="address_number" id="address_number" class="form-control" placeholder="123" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="complement">Complemento</label>
                        <input type="text" name="complement" id="complement" class="form-control" placeholder="Apto 101">
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="neighborhood">Bairro</label>
                        <input type="text" name="neighborhood" id="neighborhood" class="form-control" placeholder="Centro" required>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="postal_code">CEP (apenas números)</label>
                        <input type="text" name="postal_code" id="postal_code" class="form-control" maxlength="8" placeholder="01310100" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Criar Subconta Asaas</button>
                <a href="{{ route('seller.index') }}" class="btn btn-secondary">Voltar</a>
            </div>
        </form>
    @endif
</div>
@endsection