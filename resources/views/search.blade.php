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
            <div class="filter-section">
                <h3>Category</h3>
                <div class="category-list">
                    <label><input type="checkbox" checked> Toda as Categorias</label>
                    <label><input type="checkbox"> Esportes</label>
                    <label><input type="checkbox"> Cinema</label>
                    <label><input type="checkbox"> Shows</label>
                    <label><input type="checkbox"> Tours</label>
                </div>
            </div>

            <div class="filter-section">
                <h3>Data</h3>
                <input type="date" style="width: 100%; padding: 0.5rem;">
            </div>

            <div class="filter-section">
                <h3>Preço</h3>
                <div class="price-inputs">
                    <input type="number" placeholder="Mínimo">
                    <input type="number" placeholder="Máximo">
                </div>
            </div>

            <div class="filter-section">
                <h3>Localização</h3>
                <input type="text" placeholder="Enter city or venue" style="width: 100%; padding: 0.5rem;">
            </div>

            <button class="filter-button">Aplicar Filtros</button>
        </aside>

        <main class="main-content">
            @foreach ($tickets as $ticket)
                <div class="events-grid">
                    <h1 class="detail-title">{{ $ticket->title }}</h1>
                    <div class="detail-info">
                        <div class="info-item">
                            <span class="info-label">Date</span>
                            <span class="info-value"></span>
                        </div>
                    </div>
                </div>
            @endforeach
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
