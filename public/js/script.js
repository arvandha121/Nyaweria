document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");

    form.addEventListener("submit", function(event) {
        const name = document.getElementById("name").value;
        const amount = document.getElementById("amount").value;
        const email = document.getElementById("email").value;

        if (name === "" || amount === "" || email === "") {
            alert("Semua kolom harus diisi!");
            event.preventDefault(); // Mencegah form terkirim jika ada input yang kosong
        }

        // Bisa ditambahkan validasi lain seperti format email yang valid
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const confirmButton = document.querySelector("form button");

    confirmButton.addEventListener("click", function(event) {
        const confirmation = confirm("Apakah Anda yakin ingin melanjutkan proses pembayaran?");
        if (!confirmation) {
            event.preventDefault(); // Mencegah pengiriman form jika user tidak yakin
        }
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const processForm = document.querySelector("form");

    processForm.addEventListener("submit", function() {
        const loadingMessage = document.createElement("p");
        loadingMessage.innerText = "Memproses pembayaran, harap tunggu...";
        document.body.appendChild(loadingMessage);
    });
});
