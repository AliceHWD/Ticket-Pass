<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo')</title>

    <link rel="stylesheet" href="/css/layout.css">
    <link rel="stylesheet" href="@yield('css')">
</head>

<body>

    <header>
        <div id="header-parte-um">
            <div id="header-logo">
                <img src="/img/logo.png" alt="">
            </div>
            <h2>TicketPass</h2>
            <div>
                @guest
                    <div class="auth-buttons">
                        <a href="/register" class="header-cadastro">
                            Cadastre-se!
                        </a>
                        <a href="/login" class="header-login">Entrar</a>
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

                                <a href="/user/profile">Minha Conta</a>
                                <a href="/my-tickets">Meus Ingressos</a>
                                @auth
                                    @if (Auth::user()->seller)
                                        <a href="/seller/index">Área vendedor</a>
                                    @endif
                                @endauth



                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Sair
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>

                            </div>
                        </div>

                    </div>
                @endauth
            </div>
        </div>

        <div id="header-parte-dois">
            <a href="/" class="home-btn">
                <i class="fa-solid fa-house"></i>
                Início
            </a>
            <a href="/search">Pesquisar</a>
            <a href="/carrinho">Carrinho</a>
            <a href="/events/create">Anunciar</a>
        </div>
        <div id="header-linha"></div>
    </header>

    <main>
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
    <script>
        // Detectar rota atual e destacar botão Home
        document.addEventListener('DOMContentLoaded', function() {
            if (window.location.pathname === '/') {
                document.body.setAttribute('data-route', '/');
            }
        });
    </script>
    <script src="/js/script.js"></script>
    <script src="@yield('js')"></script>
</body>

</html>
