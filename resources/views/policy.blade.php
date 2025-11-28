@extends('layouts.main')

@section('title', 'Política de Privacidade')

@section('content')
<div class="container">
    <div class="heading">Política de Privacidade</div>
    
    <div class="content">
        <p>Esta Política de Privacidade descreve como coletamos, usamos e protegemos suas informações pessoais.</p>
        
        <h2>Coleta de Informações</h2>
        <p>Coletamos informações que você nos fornece diretamente, como quando você cria uma conta ou faz uma compra.</p>
        
        <h2>Uso das Informações</h2>
        <p>Usamos suas informações para fornecer nossos serviços, processar transações e melhorar sua experiência.</p>
        
        <h2>Proteção de Dados</h2>
        <p>Implementamos medidas de segurança adequadas para proteger suas informações pessoais.</p>
        
        <h2>Contato</h2>
        <p>Para dúvidas sobre esta política, entre em contato conosco em: ticketpassofc25@gmail.com</p>
    </div>
</div>

<style>
.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 40px 20px;
    background: #F8F9FD;
    background: linear-gradient(0deg, rgb(255, 255, 255) 0%, rgb(244, 247, 251) 100%);
    border-radius: 40px;
    border: 5px solid rgb(255, 255, 255);
    box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 30px 30px -20px;
    margin-top: 40px;
    margin-bottom: 40px;
}

.heading {
    text-align: center;
    font-weight: 900;
    font-size: 30px;
    color: rgb(16, 137, 211);
    margin-bottom: 30px;
}

.content {
    line-height: 1.6;
    color: #333;
}

.content h2 {
    color: rgb(16, 137, 211);
    margin-top: 25px;
    margin-bottom: 15px;
    font-size: 20px;
}

.content p {
    margin-bottom: 15px;
}
</style>
@endsection