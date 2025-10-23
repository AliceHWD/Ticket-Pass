function updateQuantity(itemId, change) {
    const quantityElement = document.querySelector(`[data-id="${itemId}"] .quantity`);
    let currentQuantity = parseInt(quantityElement.textContent);
    let newQuantity = currentQuantity + change;
    
    if (newQuantity < 1) {
        deleteItem(itemId);
        return;
    }
    
    fetch(`/cart/${itemId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            quantity: newQuantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Erro ao atualizar quantidade');
    });
}

function deleteItem(itemId) {
    if (!confirm('Tem certeza que deseja remover este item do carrinho?')) {
        return;
    }
    
    fetch(`/cart/${itemId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Erro ao remover item');
    });
}