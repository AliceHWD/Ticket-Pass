<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cadastro - TicketPass</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #f0f4f8 0%, #e2e8f0 100%);
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 350px;
            background: #F8F9FD;
            background: linear-gradient(0deg, rgb(255, 255, 255) 0%, rgb(244, 247, 251) 100%);
            border-radius: 40px;
            padding: 25px 35px;
            border: 5px solid rgb(255, 255, 255);
            box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 30px 30px -20px;
            margin: 20px;
        }
        
        .heading {
            text-align: center;
            font-weight: 900;
            font-size: 30px;
            color: rgb(16, 137, 211);
            margin-bottom: 20px;
        }
        
        .form {
            margin-top: 20px;
        }
        
        .input {
            width: 100%;
            background: white;
            border: none;
            padding: 15px 20px;
            border-radius: 20px;
            margin-top: 15px;
            box-shadow: #cff0ff 0px 10px 10px -5px;
            border-inline: 2px solid transparent;
            font-size: 14px;
            outline: none;
        }
        
        .input::placeholder {
            color: rgb(170, 170, 170);
        }
        
        .input:focus {
            outline: none;
            border-inline: 2px solid #12B1D1;
        }
        
        .terms-container {
            margin-top: 15px;
            margin-bottom: 10px;
        }
        
        .terms-label {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            font-size: 11px;
            color: #666;
            cursor: pointer;
        }
        
        .terms-label input[type="checkbox"] {
            margin-top: 2px;
            accent-color: rgb(16, 137, 211);
        }
        
        .terms-text a {
            color: #0099ff;
            text-decoration: none;
        }
        
        .terms-text a:hover {
            text-decoration: underline;
        }
        
        .login-button {
            display: block;
            width: 100%;
            font-weight: bold;
            background: linear-gradient(45deg, rgb(16, 137, 211) 0%, rgb(18, 177, 209) 100%);
            color: white;
            padding: 15px;
            margin: 20px auto;
            border-radius: 20px;
            box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 20px 10px -15px;
            border: none;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
            font-size: 14px;
        }
        
        .login-button:hover {
            transform: scale(1.03);
            box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 23px 10px -20px;
        }
        
        .login-button:active {
            transform: scale(0.95);
            box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 15px 10px -10px;
        }
        
        .social-account-container {
            margin-top: 25px;
        }
        
        .social-account-container .title {
            display: block;
            text-align: center;
            font-size: 10px;
            color: rgb(170, 170, 170);
        }
        
        .social-account-container .social-accounts {
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 5px;
        }
        
        .social-account-container .social-accounts .social-button {
            background: linear-gradient(45deg, rgb(0, 0, 0) 0%, rgb(112, 112, 112) 100%);
            border: 5px solid white;
            padding: 5px;
            border-radius: 50%;
            width: 40px;
            aspect-ratio: 1;
            display: grid;
            place-content: center;
            box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 12px 10px -8px;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
        }
        
        .social-account-container .social-accounts .social-button .svg {
            fill: white;
            margin: auto;
            width: 16px;
            height: 16px;
        }
        
        .social-account-container .social-accounts .social-button:hover {
            transform: scale(1.2);
        }
        
        .social-account-container .social-accounts .social-button:active {
            transform: scale(0.9);
        }
        
        .agreement {
            display: block;
            text-align: center;
            margin-top: 15px;
        }
        
        .agreement a {
            text-decoration: none;
            color: #0099ff;
            font-size: 11px;
        }
        
        .agreement a:hover {
            text-decoration: underline;
        }
        
        .error-message {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            padding: 12px;
            border-radius: 15px;
            border: 1px solid rgba(239, 68, 68, 0.2);
            margin-bottom: 15px;
            font-size: 12px;
        }
        
        @media (max-width: 480px) {
            .container {
                max-width: 320px;
                padding: 20px 25px;
                margin: 10px;
            }
            
            .heading {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="heading">Bem-vindo à TicketPass</div>
        
        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        
        <form method="POST" action="{{ route('register') }}" class="form">
            @csrf
            <input required class="input" type="text" name="name" id="name" placeholder="Nome completo" value="{{ old('name') }}">
            <input required class="input" type="email" name="email" id="email" placeholder="E-mail" value="{{ old('email') }}">
            <input required class="input" type="password" name="password" id="password" placeholder="Senha">
            <input required class="input" type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirme a senha">
            
            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="terms-container">
                    <label class="terms-label">
                        <input type="checkbox" name="terms" id="terms" required>
                        <span class="terms-text">
                            Eu concordo com os 
                            <a href="{{ route('terms.show') }}" target="_blank">Termos de Serviço</a> 
                        </span>
                    </label>
                </div>
            @endif
            
            <input class="login-button" type="submit" value="Cadastrar">
        </form>
        
        
        <span class="agreement">
            <a href="{{ route('login') }}">Já tem uma conta? Faça login</a>
        </span>
    </div>
</body>
</html>