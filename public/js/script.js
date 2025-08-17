//menu lateral
// Função para abrir e fechar o menu
function toggleMenu() {
    const sidebar = document.getElementById('sidebar');
    const menuIcon = document.getElementById('menu-icon');
    const content = document.getElementById('content');

    // Se o menu estiver fechado, abra-o
    if (sidebar.classList.contains('open')) {
        sidebar.classList.remove('open');
        content.classList.remove('shifted');
        menuIcon.style.display = 'block'; // Exibe o ícone novamente
    } else {
        sidebar.classList.add('open');
        content.classList.add('shifted');
        menuIcon.style.display = 'none'; // Esconde o ícone
    }
}

// Fecha o menu se o clique for fora do menu
document.addEventListener('click', function (event) {
    const sidebar = document.getElementById('sidebar');
    const menuIcon = document.getElementById('menu-icon');
    const content = document.getElementById('content');

    // Verifica se o clique foi fora do menu e do ícone
    if (!sidebar.contains(event.target) && !menuIcon.contains(event.target)) {
        if (sidebar.classList.contains('open')) {
            sidebar.classList.remove('open');
            content.classList.remove('shifted');
            menuIcon.style.display = 'block'; // Reexibe o ícone
        }
    }
});

//aba visitante
function toggleDropdown() {
    const dropdown = document.getElementById('dropdown-menu');
    if (dropdown.style.display === 'block') {
        dropdown.style.display = 'none';
    } else {
        dropdown.style.display = 'block';
    }
}

// Fecha o dropdown ao clicar fora
document.addEventListener('click', function (event) {
    const dropdown = document.getElementById('dropdown-menu');
    const button = document.querySelector('.dropdown-button');
    if (!button.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.style.display = 'none';
    }
});

//carrossel
const slides = document.querySelector('.slides');
const dots = document.querySelectorAll('.dot');
const totalSlides = dots.length;
let currentIndex = 0;
let interval;

// Atualiza o slide ativo
function updateSlide(index) {
    slides.style.transform = `translateX(-${index * 100}%)`;
    dots.forEach(dot => dot.classList.remove('active'));
    dots[index].classList.add('active');
}

// Navegação automática
function startAutoSlide() {
    interval = setInterval(() => {
        currentIndex = (currentIndex + 1) % totalSlides;
        updateSlide(currentIndex);
    }, 3000);
}

// Clique nos pontos para navegação manual
dots.forEach(dot => {
    dot.addEventListener('click', () => {
        currentIndex = parseInt(dot.dataset.index);
        updateSlide(currentIndex);
        clearInterval(interval); // Pausa a navegação automática ao interagir
        startAutoSlide(); // Reinicia o timer
    });
});

// Inicializa o carrossel
updateSlide(currentIndex);
startAutoSlide();