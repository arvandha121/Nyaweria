// script.js

document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");

    // Validasi input saat submit form
    form.addEventListener("submit", function(event) {
        const name = document.getElementById("name").value;
        const amount = document.getElementById("amount").value;
        const email = document.getElementById("email").value;

        if (name === "" || amount === "" || email === "") {
            alert("Semua kolom harus diisi!");
            event.preventDefault(); // Mencegah form terkirim jika ada input yang kosong
        }

        if (amount < 1000) {
            alert("Jumlah dukungan minimal adalah 1.000 rupiah.");
            event.preventDefault(); // Mencegah submit jika jumlah kurang dari 1.000
        }
    });
});

function setDonationAmount(amount, button) {
    document.getElementById('amount').value = amount;
    validateAmount();
    const buttons = document.querySelectorAll('.donation-buttons button');
    buttons.forEach(btn => btn.classList.remove('active'));
    button.classList.add('active');
}

function validateAmount() {
    const amountInput = document.getElementById('amount');
    const submitButton = document.getElementById('submit-button');
    const errorMessage = document.getElementById('error-message');
    const amount = parseInt(amountInput.value);

    // Tampilkan notifikasi error hanya jika kolom diisi dan jumlah kurang dari 1.000
    if (amountInput.value === "") {
        errorMessage.style.display = "none"; // Sembunyikan notifikasi jika belum ada input
        submitButton.disabled = true; // Nonaktifkan tombol jika belum ada input
    } else if (amount >= 1000) {
        errorMessage.style.display = "none"; // Sembunyikan pesan error jika jumlah valid
        submitButton.disabled = !document.getElementById('accept-terms').checked;
    } else {
        errorMessage.style.display = "block"; // Tampilkan pesan error jika jumlah kurang dari 1.000
        submitButton.disabled = true;
    }
}

function toggleSubmitButton() {
    const submitButton = document.getElementById('submit-button');
    const amount = parseInt(document.getElementById('amount').value);

    submitButton.disabled = !document.getElementById('accept-terms').checked || isNaN(amount) || amount < 1000;
}