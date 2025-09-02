
// cartao e pix
const creditRadio = document.getElementById('credit-radio'); //radio cred
const pixRadio = document.getElementById('pix-radio'); //radio pix
const creditForm = document.getElementById('credit-form');
const pixForm = document.getElementById('pix-form');
const addCardButton = document.getElementById('add-card-button');
const cardForm = document.querySelector('.form-section');
const saveCardButton = document.getElementById('save-card-button');
const savedCards = document.getElementById('saved-cards');
const copyPixButton = document.getElementById('copy-pix-button');
const pixCopyCode = document.getElementById('pix-copy-code');
const cardTrem = document.querySelector('.card-section');
const cardNumberInput = document.getElementById('card-number');
const cardNameInput = document.getElementById('card-name');
const cardExpiryInput = document.getElementById('card-expiry');
const cardCvvInput = document.getElementById('card-cvv');
const cardNumberDisplay = document.querySelector('.card .number');
const cardNameDisplay = document.querySelector('.card .name');
const cardExpiryDisplay = document.querySelector('.card .expiry');
const cardCvvDisplay = document.querySelector('.card .cvv');

//aparecer
creditRadio.addEventListener('change', () => {
    if (creditRadio.checked) {
        creditForm.style.display = 'block';
        pixForm.style.display = 'none';
    }
});
pixRadio.addEventListener('change', () => {
    if (pixRadio.checked) {
        creditForm.style.display = 'none';
        pixForm.style.display = 'block';
    }
});

//add cartao
addCardButton.addEventListener('click', () => {
    cardForm.style.display = 'block';
    cardTrem.style.display = 'block';
});

// salvar cartao
saveCardButton.addEventListener('click', () => {
    const cardNumber = document.getElementById('card-number').value;
    const cardName = document.getElementById('card-name').value;
    const cardExpiry = document.getElementById('card-expiry').value;

    if (cardNumber && cardName && cardExpiry) {
        const cardDiv = document.createElement('div');
        cardDiv.classList.add('saved-card');
        cardDiv.textContent = `${cardName} - ${cardNumber} - ${cardExpiry}`;
        savedCards.appendChild(cardDiv);

        cardForm.style.display = 'none';
        cardTrem.style.display = 'none';
    } else {
        alert('Please fill all fields!');
    }
});

copyPixButton.addEventListener('click', () => {
    pixCopyCode.select();
    navigator.clipboard.writeText(pixCopyCode.value);
    alert('PIX code copied to clipboard!');
});

// Mask for card number
cardNumberInput.addEventListener('input', (e) => {
    let value = e.target.value.replace(/\D/g, '');
    value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
    e.target.value = value;
    cardNumberDisplay.textContent = value || '#### #### #### ####';
});

cardNameInput.addEventListener('input', (e) => {
    cardNameDisplay.textContent = e.target.value.toUpperCase() || 'NOME';
});

cardExpiryInput.addEventListener('input', (e) => {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 2) {
        value = value.slice(0, 2) + '/' + value.slice(2, 4);
    }
    e.target.value = value;
    cardExpiryDisplay.textContent = value || 'MM/AA';
});

cardCvvInput.addEventListener('input', (e) => {
    cardCvvDisplay.textContent = `CVV: ${e.target.value || '###'}`;
});