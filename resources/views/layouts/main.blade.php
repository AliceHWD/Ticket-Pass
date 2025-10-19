<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo')</title>

    <link rel="stylesheet" href="/css/style.css"> <!-- colocar css só pros header e rodaé com esse nome -->
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
                <a href="./index.php">
                    <img src="../imagens/logo.png" alt="">
                    <h3>OpenPass</h3>
                </a>
            </div>

            <ul>
                <li><a href="./pesquisa.php">Procurar Ingressos</a></li>
                <li><a href="/events/create">Anunciar Ingresso <i class="fa-solid fa-plus"></i></a></li>
                <li><a href="/my-tickets">Meus Ingressos</a></li>
                {{-- @auth('seller') --}}
                    <li><a href="/seller/index">Área vendedor</a></li>
                {{-- @endauth --}}
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
        <div class="box-menu">
            <div class="pesquisa">
                <a href="/search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Pesquisar
                </a>
            </div>

            <div class="ingresso">
                <a href="/events/create">
                    Anunciar Ingresso
                    <i class="fa-solid fa-plus"></i>
                </a>
            </div>

            <div class="carrinho">
                <a href="/carrinho">
                    Carrinho
                    <i class="fa-solid fa-cart-shopping"></i>
                </a>
            </div>
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
                        <a href="./pesquisa.php">Procurar Ingressos</a>
                        <a href="#">Ajuda</a>
                        {{-- <a href="/logout" method="post">Sair</a> --}}
                    </div>
                </div>

            </div>
        @endauth
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
                <a href="./areaV.php">Adicione seu ingresso</a>
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
    <script src="@yield('js')"></script>

</body>

</html>
