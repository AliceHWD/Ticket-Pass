@extends('layouts.main')

@section('titulo', 'Cadastro de Vendedor')
@section('css', '/css/vendedor.css')

@section('conteudo')
<div class="form-wrapper">
<div class="container">
    <div class="heading">Cadastro de Vendedor</div>
    <form action="/seller" method="POST" class="form">
        @csrf
        
        <input required class="input" type="text" name="cep" id="cep" placeholder="CEP" value="{{ old('cep') }}">
        @error('cep')
            <div class="error">{{ $message }}</div>
        @enderror
        
        <input required class="input" type="text" name="house_number" id="house_number" placeholder="Número da casa" value="{{ old('house_number') }}">
        @error('house_number')
            <div class="error">{{ $message }}</div>
        @enderror
        
        <input class="input" type="text" name="complement" id="complement" placeholder="Complemento (opcional)" value="{{ old('complement') }}">
        @error('complement')
            <div class="error">{{ $message }}</div>
        @enderror
        <input class="login-button" type="submit" value="Cadastrar como Vendedor">
    </form>
    
    <div class="social-account-container">
        <span class="title">Torne-se um vendedor</span>
    </div>
    <span class="agreement"><a href="#">Área de vendas TicketPass</a></span>
</div>
</div>
@endsection
