document.addEventListener('DOMContentLoaded', function () {
    const priceInput = document.getElementById('initial_price');
    const quantityInput = document.getElementById('ticketQuantity');
    const totalSpan = document.getElementById('totalAmount');
    const codesContainer = document.getElementById('ticketCodesContainer');

    function updateTotal() {
        const price = parseFloat(priceInput.value) || 0;
        const quantity = parseInt(quantityInput.value) || 0;
        const total = price * quantity;
        totalSpan.textContent = total.toFixed(2);
    }

    function generateCodeInputs() {
        const quantity = parseInt(quantityInput.value) || 0;
        codesContainer.innerHTML = '';

        if (quantity > 0) {
            const title = document.createElement('h3');
            title.textContent = 'Códigos dos Ingressos';
            codesContainer.appendChild(title);

            for (let i = 0; i < quantity; i++) {
                const div = document.createElement('div');
                div.className = 'form-group';

                const label = document.createElement('label');
                label.textContent = `Código do Ingresso ${i + 1}`;

                const input = document.createElement('input');
                input.type = 'text';
                input.name = `codes[${i}]`;
                input.placeholder = 'Digite o código do ingresso';
                input.required = true;

                div.appendChild(label);
                div.appendChild(input);
                codesContainer.appendChild(div);
            }
        }
    }

    priceInput.addEventListener('input', updateTotal);
    quantityInput.addEventListener('input', function () {
        updateTotal();
        generateCodeInputs();
    });
});