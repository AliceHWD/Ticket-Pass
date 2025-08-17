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
        menuIcon.style.display = 'block';
        z // Exibe o ícone novamente
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



function toggleDropdown() {
    const dropdown = document.getElementById('drop');
    if (dropdown.style.display === 'block') {
        dropdown.style.display = 'none';
    } else {
        dropdown.style.display = 'block';
    }
}

// Fecha o dropdown ao clicar fora
document.addEventListener('click', function (event) {
    const dropdown = document.getElementById('drop');
    const button = document.querySelector('.dropdown-button');
    if (!button.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.style.display = 'none';
    }
});

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

// Sample data for tickets
const tickets = [{
    date: '25/03/2024 19:30',
    name: 'Nome do evento',
    price: 'R$55',
    location: 'Local'
},
{
    date: '26/03/2024 20:00',
    name: 'Nome do evento',
    price: 'R$55',
    location: 'Local'
},
{
    date: '27/03/2024 18:30',
    name: 'Nome do evento',
    price: 'R$55',
    location: 'Local'
},
{
    date: '28/03/2024 21:00',
    name: 'Nome do evento',
    price: 'R$55',
    location: 'Local'
},
{
    date: '29/03/2024 19:00',
    name: 'Nome do evento',
    price: 'R$55',
    location: 'Local'
}
];

// Initialize the page
document.addEventListener('DOMContentLoaded', () => {
    // Set initial client name
    document.getElementById('clientName').textContent = 'Cliente';

    // Generate ticket cards
    generateTicketCards();

    // Setup event listeners
    setupEventListeners();
});

// Generate ticket cards
function generateTicketCards() {
    const ticketsGrid = document.querySelector('.tickets-grid');

    tickets.forEach(ticket => {
        const ticketCard = document.createElement('div');
        ticketCard.className = 'ticket-card';

        ticketCard.innerHTML = `
                    <div class="ticket-image"></div>
                    <div class="ticket-info">
                        <div class="ticket-date">${ticket.date}</div>
                        <div class="ticket-name">${ticket.name}</div>
                        <div class="ticket-price">${ticket.price}</div>
                        <div class="ticket-location">${ticket.location}</div>
                    </div>
                `;

        ticketsGrid.appendChild(ticketCard);
    });
}

// Setup event listeners
function setupEventListeners() {
    const editBtn = document.getElementById('editBtn');
    const endSessionBtn = document.querySelector('.end-session-btn');
    const deleteAccountBtn = document.querySelector('.delete-account-btn');
    const viewMoreBtn = document.querySelector('.view-more-btn');

    // Edit button functionality
    editBtn.addEventListener('click', () => {
        const inputs = document.querySelectorAll('input');
        const isEditing = editBtn.textContent === 'Editar informações';

        inputs.forEach(input => {
            input.disabled = !isEditing;
        });

        editBtn.textContent = isEditing ? 'Salvar informações' : 'Editar informações';
    });

    // End session button
    endSessionBtn.addEventListener('click', () => {
        if (confirm('Tem certeza que deseja encerrar a sessão?')) {
            // Add logout logic here
            console.log('Session ended');
        }
    });

    // Delete account button
    deleteAccountBtn.addEventListener('click', () => {
        if (confirm('Tem certeza que deseja deletar sua conta? Esta ação não pode ser desfeita.')) {
            // Add account deletion logic here
            console.log('Account deleted');
        }
    });

    // View more button
    viewMoreBtn.addEventListener('click', () => {
        // Add view more logic here
        alert('Redirecionando aos Meus Ingressos');
        window.location.href = './ingressoM.php'
    });
}

// Função para habilitar os campos de edição
document.getElementById("editBtn").addEventListener("click", function () {
    document.querySelectorAll("input").forEach(input => input.removeAttribute("disabled"));
    document.getElementById("saveBtn").style.display = "block";
    this.style.display = "none";
});