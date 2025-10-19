@extends('layouts.main')

@section('titulo', 'Início')
@section('css', '/css/style.css')

@section('conteudo')
    <div class="slides-carrossel">
        <div class="carousel">
            <div class="slides">
                <div class="slide" style="background-color: #3498db;">Slide 1</div>
                <div class="slide" style="background-color: #e74c3c;">Slide 2</div>
                <div class="slide" style="background-color: #2ecc71;">Slide 3</div>
            </div>
            <div class="navigation">
                <span class="dot" data-index="0"></span>
                <span class="dot" data-index="1"></span>
                <span class="dot" data-index="2"></span>
            </div>
        </div>
    </div>

    <div class="topicos">
        <div class="topicos-botoes">

            <div class="festa">
                <a href="./festa.php">
                    <img src="./img/festa.png" alt="">
                </a>
                <p>Festa e festivais</p>
            </div>

            <div class="shows">
                <a href="./shows.php">
                    <img src="./img/show-icon.png" alt="">
                </a>
                <p>Shows e Musicais</p>
            </div>

            <div class="esporte">
                <a href="./esporte.php">
                    <img src="./img/esporte-icon.png" alt="">
                </a>
                <p>Esportes</p>
            </div>

            <div class="palestra">
                <a href="./palesta.php">
                    <img src="./img/palestra.png" alt="">
                </a>
                <p>Palestras</p>
            </div>

            <div class="tours">
                <a href="./lazer.php">
                    <img src="./img/lazer.png" alt="">
                </a>
                <p>Lazer e tours</p>
            </div>

            <div class="cultura">
                <a href="./cultura.php">
                    <img src="./img/culture.png" alt="">
                </a>
                <p>Cultura</p>
            </div>

            <div class="more">
                <a href="./pesquisa.php">
                    <img src="./img/plus.png" alt="">
                </a>
                <p>Mais</p>
            </div>

        </div>
    </div>
    <div class="primeiros-ingressos">

        @if (count($ingressos) > 0)
            @foreach($ingressos as $ingresso)
                <a href="/events/{{ $ingresso->event_id}}" class="card-ingresso">
                    <img src="{{ $ingresso->image }}" alt="">
                    <p>{{ \Carbon\Carbon::parse($ingresso->start_event_date)->format('d/m/Y') }}</p>
                    <p class="nome">{{ $ingresso->title }}</p>
                    <div class="lugar">
                        @if($ingresso->menor_preco)
                            <strong>A partir de R$ {{ number_format($ingresso->menor_preco, 2, ',', '.') }}</strong>
                        @else
                            <strong>Consulte preços</strong>
                        @endif
                        {{ $ingresso->location }}
                    </div>
                </a>
            @endforeach
        @else
            <p>
                Não há ingressos no momento
            </p>
        @endif

    </div>

    <div class="folder">
        <div class="folder-img">
            <img src="../img/folder.png" alt="">
            <div class="text">
                <h1><span>publique</span> seu ingresso <br> com a <span>ticketpass!</span></h1>
                <a href="./areaV.php">Anunciar</a>
            </div>
        </div>
        <div class="folder-img-Mob">
            <img src="../img/folder-mobile.png" alt="">
            <div class="text-mob">
                <h1><span>publique</span> seu ingresso <br> com a <span>ticketpass!</span></h1>
                <a href="./areaV.php">Anunciar</a>
            </div>
        </div>
    </div>

    <div class="primeiros-ingressos">

       {{-- @if (count($ingressos) >= 5)
            @for ($i = 5; $i < count($ingressos); $i++)
                <a href="/events/{{ $ingressos[$i]['event_id'] }}" class="card-ingresso">
                    <img src="{{ $ingressos[$i]['image'] }}" alt="">
                    <p class="data">{{ date('d/m/Y', strtotime($ingressos[$i]['event_date'])) }}</p>
                    <p class="nome">{{ $ingressos[$i]['title'] }}</p>
                    <div class="lugar">
                        <strong>R${{ $ingressos[$i]['initial_price'] }} </strong>
                        {{ $ingressos[$i]['location'] }}
                    </div>
                </a>
            @endfor
        @endif  --}}

        </main>

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

    @section('js', '/js/script.js')