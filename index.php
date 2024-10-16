<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dukung Arvandha</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMh51D2dUimjFczdAcF30gDho9IPn6D/8H6x0" crossorigin="anonymous">
    <script>
        function setDonationAmount(amount, button) {
            document.getElementById('amount').value = amount; // Mengatur nilai input jumlah donasi
            
            // Menghapus kelas 'active' dari semua tombol
            const buttons = document.querySelectorAll('.donation-buttons button');
            buttons.forEach(btn => btn.classList.remove('active'));
            
            // Menambahkan kelas 'active' ke tombol yang ditekan
            button.classList.add('active');
        }
    </script>
</head>
<body>
    <div class="container">
        <img src="img/unnamed.jpg" alt="Lingkaran" class="responsive-image">
        
        <h1><i class="fas fa-hand-holding-heart"></i> Dukung Arvandha</h1>
        <form action="confirm" method="POST">
            <div class="form-container">
                <div class="form-column">
                    <div class="form-group">
                        <label for="name">Nama Lengkap:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="amount">Nominal (IDR):</label>
                        <input type="number" id="amount" name="amount" required>
                    </div>
                </div>

                <div class="form-column">
                    <div class="form-group">
                        <label for="message">Pesan:</label>
                        <textarea id="message" name="message" rows="4" placeholder="Tulis pesan Anda di sini..." required></textarea>
                    </div>
                </div>
            </div>

            <div class="donation-buttons">
                <button type="button" onclick="setDonationAmount(1000, this)">1.000</button>
                <button type="button" onclick="setDonationAmount(5000, this)">5.000</button>
                <button type="button" onclick="setDonationAmount(10000, this)">10.000</button>
                <button type="button" onclick="setDonationAmount(25000, this)">25.000</button>
            </div>

            <button type="submit">Konfirmasi Dukungan</button>
        </form>
    </div>
</body>
</html>
