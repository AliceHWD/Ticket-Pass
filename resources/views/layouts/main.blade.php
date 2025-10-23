<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo')</title>

    <link rel="stylesheet" href="/css/style.css"> 
    <link rel="stylesheet" href="@yield('css')">
</head>

<body>

    <header>
        <div class="logo">
            <a href="/">
                <img src="/img/logo.png" alt="">
                <h3>TicketPass</h3>
            </a>
        </div>

        <div class="menu-icon" id="menu-icon" onclick="toggleMenu()">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>

        <!-- Menu Lateral -->
        <div class="sidebar" id="sidebar">

            <div class="logo-menu">
                <a href="">
                    <img src="" alt="">
                    <h3>OpenPass</h3>
                </a>
            </div>

            <ul>
                <li><a href="/search">Procurar Ingressos</a></li>
                <li><a href="/events/create">Anunciar Ingresso <i class="fa-solid fa-plus"></i></a></li>
                <li><a href="/my-tickets">Meus Ingressos</a></li>
                @auth
                    <li><a href="/seller/index">Área vendedor</a></li>
                @endauth
                <li><a href="/register">Cadastrar-se!</a></li>
            </ul>

            <div class="user-menu">
                <a href="/register">
                    <div class="quadro">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <p>Visitante</p>
                </a>
            </div>

            <div class="redes">
                <i class="fa-brands fa-instagram"></i>
                <i class="fa-brands fa-x-twitter"></i>
                <i class="fa-brands fa-whatsapp"></i>
            </div>

        </div>

        {{-- Header --}}
        <div class="box-menu">
            <div class="header-menu">
                <a href="/">
                    <i class="fa-solid fa-house"></i>
                    Menu
                </a>
            </div>

            <div class="pesquisa">
                <a href="/search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Pesquisar
                </a>
            </div>

            <div class="ingresso">
                <a href="/events/create">
                    <i class="fa-solid fa-plus"></i>
                    Anunciar Ingresso
                </a>
            </div>

            <div class="carrinho">
                <a href="/carrinho">
                    <i class="fa-solid fa-cart-shopping"></i>
                    Carrinho
                </a>
            </div>
            
        @guest
            <div class="cadastro">
                <a href="/register">
                    Cadastrar-se!
                </a>
                <a href="/login">Entrar</a>
            </div>
        @endguest

        @auth
            <div class="perfil" id="profile">
                <div class="dropdown-container">
                    <button class="dropdown-button" onclick="toggleDropdown()">
                        Perfil
                        <i class="fa-solid fa-user"></i>
                    </button>
                    <div id="dropdown-menu" class="dropdown-menu">

                        <a href="/dashboard">Minha Conta</a>
                        <a href="/my-tickets">Meus Ingressos</a>
                        <li><a href="/seller/index">Área vendedor</a></li>
                        <a href="/search">Procurar Ingressos</a>
                        <a href="#">Ajuda</a>
                        {{-- <a href="/logout" method="post">Sair</a> --}}
                    </div>
                </div>

            </div>
        @endauth
        </div>

    </header>

    <main>
        {{-- Colocar a flash message --}}

        @yield('conteudo')
    </main>

    <footer>
        <div class="logo">
            <img src="/img/logo.png" alt="">
            <h3>TicketPass</h3>
        </div>

        <div class="menu-footer">
            <div class="pt-cima">
                <a href="/search">Encontre Ingressos</a>
                <a href="#">Cidades</a>
                <a href="#">Categorias</a>
                <a href="/events/create">Anuncie seu ingresso</a>
                <a href="#">Ajuda</a>
            </div>
            <div class="linha"></div>
            <div class="pt-baixo">
                <a href="index.php">Home</a>
                <a href="#">Sobre</a>
                <a href="#">Termos e Políticas</a>
            </div>
        </div>

        <div class="redes-footer">
            <a href="#">
                <i class="fa-brands fa-instagram"></i>
            </a>
            <a href="#">
                <i class="fa-brands fa-whatsapp"></i>
            </a>
            <a href="#">
                <i class="fa-brands fa-x-twitter"></i>
            </a>
        </div>
    </footer>

    <script src="https://kit.fontawesome.com/5553e94d09.js" crossorigin="anonymous"></script>
    <script src="/js/script.js"></script>
    <script src="@yield('js')"></script>
</body>

</html>
