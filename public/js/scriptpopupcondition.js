function setDonationAmount(amount, button) {
    document.getElementById('amount').value = amount;
    const buttons = document.querySelectorAll('.donation-buttons button');
    buttons.forEach(btn => btn.classList.remove('active'));
    button.classList.add('active');
}

function showTerms(event) {
    event.preventDefault(); // Mencegah perilaku default dari hyperlink (#)
    document.getElementById('terms-popup').style.display = 'flex';
}

function hideTerms() {
    document.getElementById('terms-popup').style.display = 'none';
}

function toggleSubmitButton() {
    const checkbox = document.getElementById('accept-terms');
    const submitButton = document.getElementById('submit-button');
    submitButton.disabled = !checkbox.checked;
}
