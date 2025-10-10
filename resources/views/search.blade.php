@extends('layouts.main')

@section('titulo', 'Procurar')
@section('css', '/css/search.css')

@section('conteudo')
    <div class="search-container">
        <div class="search-bar">
            <form action="/search" method="get">
                <input type="text" placeholder="Buscar" name="search">
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
                @if (!empty($tickets))
                    <h2>Não há ingressos no momento</h2>
                @endif
                @foreach ($tickets as $ticket)
                    <a href="/tickets/{{ $ticket->ticket_id }}" class="card-ingresso">
                        <img src="{{ $ticket->image }}" alt="">
                        <p class="data">{{ \Carbon\Carbon::parse($ticket->event_date)->format('d/m/Y') }}</p>
                        <p class="nome">{{ $ticket->title }}</p>
                        <div class="lugar">
                            <strong>R${{ $ticket->initial_price }} </strong>
                            {{ $ticket->location }}
                        </div>
                    </a> 
                @endforeach
            </div>
        </main>

        <div class="detail-view">
            <div class="detail-header">
                <button class="back-button">← Back to Events</button>
            </div>
            <div class="detail-content">
                <!-- Detail content will be populated by JavaScript -->
            </div>
        </div>

    </div>

    <div class="footer-mob">

        <div class="container-buttons">
            <div class="inicio">
                <a href="./index.php">
                    <i class="fa-solid fa-house"></i>
                    Início
                </a>
            </div>
            <div class="anunciar">
                <a href="./areaV.php">
                    <i class="fa-solid fa-plus"></i>
                    Anunciar
                </a>
            </div>
            <div class="procura">
                <a href="./pesquisa.php">
                    <i class="fa-solid fa-globe"></i>
                    Procurar
                </a>
            </div>
            <div class="ingressos">
                <a href="./ingressoM.php">
                    <i class="fa-solid fa-ticket"></i>
                    Ingressos
                </a>
            </div>
            <div class="carrinho-footer">
                <a href="./cart.php">
                    <i class="fa-solid fa-cart-shopping"></i>
                    Carrinho
                </a>
            </div>
            <div class="perfil-mob">
                <a href="./perfil/perfil.php">
                    <i class="fa-solid fa-user"></i>
                    Perfil
                </a>
            </div>
        </div>

    </div>

@endsection

{{-- @section('js', '/js/search.js') --}}
