@extends('layouts.main')

@section('titulo', 'Procurar')

@section('css', '/css/search.css')

@section('conteudo')
    <div class="search-container">
        <div class="search-header">
            <h1>Encontre seu evento perfeito</h1>
            <p>Descubra experiências incríveis na sua cidade</p>
        </div>
        <div class="search-bar">
            <form action="/search" method="get">
                <input type="text" placeholder="Buscar" name="search">
                <button type="submite" id="btn-busca">
                    <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="container">
        <aside class="filtros-btn">
            <form action="/filter" method="get">
                @csrf
                <div class="filter-section">
                    <h3>Category</h3>
                    <div class="category-list">
                        <label><input type="checkbox" name="categories[]" value="Show"> Shows</label>
                        <label><input type="checkbox" name="categories[]" value="Esportes"> Esportes</label>
                        <label><input type="checkbox" name="categories[]" value="Festa"> Festa</label>
                        <label><input type="checkbox" name="categories[]" value="Palestra"> Palestras</label>
                        <label><input type="checkbox" name="categories[]" value="Lazer"> Lazer</label>
                        <label><input type="checkbox" name="categories[]" value="Cultura"> Cultura</label>
                    </div>
                </div>
                <div class="filter-section">
                    <h3>Data</h3>
                    <input type="date" name="date" style="width: 100%; padding: 0.5rem;">
                </div>
                <div class="filter-section">
                    <h3>Preço</h3>
                    <div class="price-inputs">
                        <input type="number" placeholder="Mínimo" name="precoMinimo">
                        <input type="number" placeholder="Máximo" name="precoMaximo">
                    </div>
                </div>
                <div class="filter-section">
                    <h3>Localização</h3>
                    <input type="text" placeholder="Digite cidade ou local" name="localizacao"
                        style="width: 100%; padding: 0.5rem;">
                </div>
                <button type="submit" class="filter-button">Aplicar Filtros</button>
            </form>
            <a href="/search">Limpar Filtros</a>
        </aside>

        <main class="main-content">
            @if (!empty($searchTerm))
                <h2>Resultados de: {{ $searchTerm }}</h2>
            @endif

            <div class="tickets-list">
                @if ($events->isNotEmpty())
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
                                    @if ($event->tickets->count() > 0)
                                        <p class="card__price">R$ {{ number_format($event->tickets->min('initial_price'), 2, ',', '.') }}</p>
                                    @else
                                        <p class="card__price">Consulte preços</p>
                                    @endif
                                    <form method="GET" action="/events/{{ $event->event_id }}" onclick="event.stopPropagation()">
                                        <button type="submit" class="card__button"><i class="fas fa-eye"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="no-events">
                        @if (!empty($searchTerm))
                            <h2>Nenhum resultado encontrado para "{{ $searchTerm }}"</h2>
                        @else
                            <h2>Não há ingressos no momento</h2>
                        @endif
                    </div>
                @endif
            </div>

    </div>
    </main>
    </div>
@endsection
