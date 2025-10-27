@extends('layouts.main')

@section('titulo', 'Procurar')

@section('css', '/css/search.css')

@section('conteudo')
    <div class="search-container">
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
                        <label><input type="checkbox" name="categories[]" value="esportes"> Esportes</label>
                        <label><input type="checkbox" name="categories[]" value="cinema"> Cinema</label>
                        <label><input type="checkbox" name="categories[]" value="Show"> Shows</label>
                        <label><input type="checkbox" name="categories[]" value="tours"> Tours</label>
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
                    <input type="text" placeholder="Enter city or venue" name="localizacao"
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

            <div class="events-grid">
                @if ($events->isNotEmpty())
                    @foreach ($events as $event)
                        <a href="/events/{{ $event->event_id }}" class="card-ingresso">
                            <img src="{{ $event->image }}" alt="">
                            <p class="data">{{ \Carbon\Carbon::parse($event->start_event_date)->format('d/m/Y') }}</p>
                            <p class="nome">{{ $event->title }}</p>
                            <div class="lugar">
                                @if ($event->tickets->count() > 0)
                                    <strong>A partir de R$
                                        {{ number_format($event->tickets->min('initial_price'), 2, ',', '.') }}</strong>
                                @else
                                    <strong>Consulte preços</strong>
                                @endif
                                {{ $event->location }}
                            </div>
                        </a>
                    @endforeach
                @else
                    @if (!empty($searchTerm))
                        <h2>Nenhum resultado encontrado para "{{ $searchTerm }}"</h2>
                    @else
                        <h2>Não há ingressos no momento</h2>
                    @endif
                @endif
            </div>

    </div>
    </main>
    </div>
@endsection
