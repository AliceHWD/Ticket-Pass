@extends('layouts.main')

@section('titulo', 'Início')
@section('css', '/css/style.css')

@section('conteudo')
    <div class="slides-carrossel">
        <div class="carousel">
            <div class="slides">
                <div class="slide slide-1">
                    <div class="slide-content">
                        <h2>Descubra Eventos Incríveis</h2>
                        <p>Encontre os melhores eventos da sua cidade</p>
                    </div>
                </div>
                <div class="slide slide-2">
                    <div class="slide-content">
                        <h2>Shows e Espetáculos</h2>
                        <p>Viva experiências únicas e inesquecíveis</p>
                    </div>
                </div>
                <div class="slide slide-3">
                    <div class="slide-content">
                        <h2>Cultura e Entretenimento</h2>
                        <p>Explore o melhor da cultura local</p>
                    </div>
                </div>
            </div>
            <div class="navigation">
                <button class="dot" data-index="0" aria-label="Ir para slide 1"></button>
                <button class="dot" data-index="1" aria-label="Ir para slide 2"></button>
                <button class="dot" data-index="2" aria-label="Ir para slide 3"></button>
            </div>
        </div>
    </div>

    <div class="topicos">
        <div class="topicos-botoes">

            <div class="shows categoria-item">
                <a href="{{ route('events.category', 'show') }}" aria-label="Ver shows e musicais" class="categoria-shows">
                    <img src="{{ asset('img/show-icon.png') }}" alt="Shows e Musicais">
                </a>
                <p>Shows e Musicais</p>
            </div>

            <div class="esporte categoria-item">
                <a href="{{ route('events.category', 'esportes') }}" aria-label="Ver eventos esportivos"
                    class="categoria-esporte">
                    <img src="{{ asset('img/esporte-icon.png') }}" alt="Esportes">
                </a>
                <p>Esportes</p>
            </div>

            <div class="festa categoria-item">
                <a href="{{ route('events.category', 'festa') }}" aria-label="Ver festas e festivais"
                    class="categoria-festa">
                    <img src="{{ asset('img/festa.png') }}" alt="Festa e festivais">
                </a>
                <p>Festa e festivais</p>
            </div>

            <div class="palestra categoria-item">
                <a href="{{ route('events.category', 'palestra') }}" aria-label="Ver palestras" class="categoria-palestra">
                    <img src="{{ asset('img/palestra.png') }}" alt="Palestras">
                </a>
                <p>Palestras</p>
            </div>

            <div class="tours categoria-item">
                <a href="{{ route('events.category', 'lazer') }}" aria-label="Ver lazer e tours" class="categoria-tours">
                    <img src="{{ asset('img/lazer.png') }}" alt="Lazer e tours">
                </a>
                <p>Lazer e tours</p>
            </div>

            <div class="cultura categoria-item">
                <a href="{{ route('events.category', 'cultura') }}" aria-label="Ver eventos culturais"
                    class="categoria-cultura">
                    <img src="{{ asset('img/culture.png') }}" alt="Cultura">
                </a>
                <p>Cultura</p>
            </div>

            <div class="more categoria-item">
                <a href="/search" aria-label="Ver mais categorias" class="categoria-more">
                    <img src="{{ asset('img/plus.png') }}" alt="Mais">
                </a>
                <p>Mais</p>
            </div>

        </div>
    </div>

    <div class="primeiros-ingressos">
        @if ($ingressos && count($ingressos) > 0)
            <div class="tickets-list">
                @foreach ($ingressos as $ingresso)
                    <div class="card" onclick="window.location='/events/{{ $ingresso->event_id }}'">
                        <div class="card__shine"></div>
                        <div class="card__glow"></div>
                        <div class="card__content">
                            <div class="card__image"></div>
                            <div class="card__text">
                                <h4 class="card__title">{{ $ingresso->title }}</h4>
                                <p class="card__description">{{ $ingresso->location }} -
                                    {{ \Carbon\Carbon::parse($ingresso->start_event_date)->format('d/m/Y') }}</p>
                            </div>
                            <div class="card__footer">
                                @if ($ingresso->tickets->count() < 0)
                                    <p>Consulte preços</p>
                                @elseif ($ingresso->tickets->count() == 1)
                                    <p class="card__price">R$
                                        {{ number_format($ingresso->tickets->min('initial_price'), 2, ',', '.') }}</p>
                                @else
                                    <p class="card__price">A partir de: <br> R$
                                        {{ number_format($ingresso->tickets->min('initial_price'), 2, ',', '.') }}</p>
                                @endif

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <h2>Não há ingressos no momento</h2>
        @endif
    </div>

    <div class="folder">
        <div class="folder-section">
            <picture>
                <source media="(max-width: 768px)" srcset="{{ asset('img/folder_mobile.png') }}">
                <img src="{{ asset('img/folder.png') }}" alt="Publique seu ingresso com a TicketPass" class="folder-image">
            </picture>
            <div class="folder-text">
                <h2>Publique seu ingresso com a TicketPass!</h2>
                <p>Alcance milhares de pessoas e venda seus ingressos de forma fácil e segura</p>
            </div>
            <div class="folder-button-container">
                <a href="/events/create" class="folder-button">
                    <i class="fas fa-plus"></i> Anunciar Evento
                </a>
            </div>
        </div>
    </div>

    <div class="footer-mob">
        <div class="container-buttons">
            <div class="inicio">
                <a href="./index.php" aria-label="Ir para início">
                    <i class="fa-solid fa-house"></i>
                    Início
                </a>
            </div>
            <div class="anunciar">
                <a href="./areaV.php" aria-label="Anunciar evento">
                    <i class="fa-solid fa-plus"></i>
                    Anunciar
                </a>
            </div>
            <div class="procura">
                <a href="./pesquisa.php" aria-label="Procurar eventos">
                    <i class="fa-solid fa-globe"></i>
                    Procurar
                </a>
            </div>
            <div class="ingressos">
                <a href="./ingressoM.php" aria-label="Meus ingressos">
                    <i class="fa-solid fa-ticket"></i>
                    Ingressos
                </a>
            </div>
            <div class="carrinho-footer">
                <a href="./cart.php" aria-label="Ver carrinho">
                    <i class="fa-solid fa-cart-shopping"></i>
                    Carrinho
                </a>
            </div>
            <div class="perfil-mob">
                <a href="./perfil/perfil.php" aria-label="Ver perfil">
                    <i class="fa-solid fa-user"></i>
                    Perfil
                </a>
            </div>
        </div>
    </div>
@endsection

@section('js', '/js/script.js')
