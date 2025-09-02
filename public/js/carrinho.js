const cartItems = [
    {
        id: 1,
        name: 'Nome',
        date: 'data',
        location: 'local',
        price: 75.99,
        quantity: 1
    },
    {
        id: 2,
        name: 'Nome',
        date: 'data',
        location: 'local',
        price: 25.00,
        quantity: 1
    }
];

function createCartItem(item) {
    return `
                <div class="cart-item" data-id="${item.id}">
                <div class="item-image"></div>
                <div class="item-details">
                    <h3 class="item-name">${item.name}</h3>
                    <p class="item-meta">${item.date} - ${item.location}</p>
                    <div class="quantity-controls">
                    <button class="quantity-btn minus" onclick="updateQuantity(${item.id}, -1)">-</button>
                    <span class="quantity">${item.quantity}</span>
                    <button class="quantity-btn plus" onclick="updateQuantity(${item.id}, 1)">+</button>
                    </div>
                </div>
                <span class="item-price">R$${item.price.toFixed(2)}</span>
                <button class="delete-btn" onclick="deleteItem(${item.id})">
                    <i class="fas fa-trash"></i>
                </button>
                </div>
            `;
}

function renderCart() {
    const cartContainer = document.getElementById('cartItems');
    cartContainer.innerHTML = cartItems.map(item => createCartItem(item)).join('');
    updateTotal();
}

window.updateQuantity = function (itemId, change) {
    const item = cartItems.find(item => item.id === itemId);
    if (item) {
        const newQuantity = item.quantity + change;
        if (newQuantity >= 1) {
            item.quantity = newQuantity;
            renderCart();
        }
    }
};

window.deleteItem = function (itemId) {
    const index = cartItems.findIndex(item => item.id === itemId);
    if (index !== -1) {
        cartItems.splice(index, 1);
        renderCart();
    }
};

function updateTotal() {
    const total = cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    document.getElementById('totalAmount').textContent = `R$${total.toFixed(2)}`;
}

const finalizarCompra = document.querySelector('.checkout-button');
finalizarCompra.addEventListener('click', () => {
    alert('Redirecionando a página de pagamento');
    window.location.href = '/pagamento'
});

// Initial render
renderCart();