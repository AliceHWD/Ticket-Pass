@extends('layouts.main')

@section('titulo', ucfirst($category))
@section('css', '/css/category.css')

@section('conteudo')
    <div class="category-header">
        <div class="category-title">
            <div class="category-icon">
                @if($category == 'show')
                    <div class="categoria-shows">
                        <img src="{{ asset('img/show-icon.png') }}" alt="Shows e Musicais">
                    </div>
                @elseif($category == 'esportes')
                    <div class="categoria-esporte">
                        <img src="{{ asset('img/esporte-icon.png') }}" alt="Esportes">
                    </div>
                @elseif($category == 'festa')
                    <div class="categoria-festa">
                        <img src="{{ asset('img/festa.png') }}" alt="Festa e festivais">
                    </div>
                @elseif($category == 'palestra')
                    <div class="categoria-palestra">
                        <img src="{{ asset('img/palestra.png') }}" alt="Palestras">
                    </div>
                @elseif($category == 'lazer')
                    <div class="categoria-tours">
                        <img src="{{ asset('img/lazer.png') }}" alt="Lazer e tours">
                    </div>
                @elseif($category == 'cultura')
                    <div class="categoria-cultura">
                        <img src="{{ asset('img/culture.png') }}" alt="Cultura">
                    </div>
                @else
                    <div class="categoria-more">
                        <img src="{{ asset('img/plus.png') }}" alt="Mais">
                    </div>
                @endif
            </div>
            <p>Encontre os melhores eventos de 
                @if($category == 'show') Shows e Musicais
                @elseif($category == 'esportes') Esportes
                @elseif($category == 'festa') Festa e festivais
                @elseif($category == 'palestra') Palestras
                @elseif($category == 'lazer') Lazer e tours
                @elseif($category == 'cultura') Cultura
                @else {{ $category }}
                @endif
            </p>
        </div>
    </div>

    <div class="category-events">
        <!-- Debug: Buscando categoria: {{ $category }} -->
        <!-- Debug: Total events found: {{ count($events) }} -->
        <!-- Debug: Categorias disponíveis: {{ implode(', ', $allCategories ?? []) }} -->
        @if(count($events) > 0)
            <!-- Debug: First event category: {{ $events->first()->category ?? 'N/A' }} -->
            <!-- Debug: First event title: {{ $events->first()->title ?? 'N/A' }} -->
        @endif
        @if ($events && count($events) > 0)
            <div class="tickets-list">
                @foreach ($events as $event)
                    <div class="card" onclick="window.location='/events/{{ $event->event_id }}'">
                        <div class="card__shine"></div>
                        <div class="card__glow"></div>
                        <div class="card__content">
                            <div class="card__image"></div>
                            <div class="card__text">
                                <h4 class="card__title">{{ $event->title }}</h4>
                                <p class="card__description">{{ $event->location }} - {{ \Carbon\Carbon::parse($event->start_event_date)->format('d/m/Y') }}</p>
                            </div>
                            <div class="card__footer">
                                @if ($event->tickets->count() < 0)
                                    <p>Consulte preços</p>
                                @elseif ($event->tickets->count() == 1)
                                    <p class="card__price">R$
                                        {{ number_format($event->tickets->min('initial_price'), 2, ',', '.') }}</p>
                                @else
                                    <p class="card__price">A partir de: <br> R$
                                        {{ number_format($event->tickets->min('initial_price'), 2, ',', '.') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-events">
                <h2>Nenhum evento encontrado</h2>
                <p>Não há eventos disponíveis na categoria {{ $category }} no momento.</p>
                <a href="/" class="back-button">Voltar ao início</a>
            </div>
        @endif
    </div>
@endsection