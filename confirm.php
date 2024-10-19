<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['name'] = htmlspecialchars($_POST['name']);
    $_SESSION['amount'] = htmlspecialchars($_POST['amount']);
    $_SESSION['email'] = htmlspecialchars($_POST['email']);
    $_SESSION['message'] = htmlspecialchars($_POST['message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Dukungan</title>
    <link rel="stylesheet" href="public/css/confirm.css">
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-Q7g78xXsc5ZzWo-X"></script>
</head>
<body>
    <div class="container">
        <h1>Konfirmasi Dukungan Anda</h1>
        <p><strong>Nama:</strong> <?php echo isset($_SESSION['name']) ? $_SESSION['name'] : 'Tidak ada data'; ?></p>
        <p><strong>Email:</strong> <?php echo isset($_SESSION['email']) ? $_SESSION['email'] : 'Tidak ada data'; ?></p>
        <p><strong>Jumlah Nominal:</strong> Rp <?php echo isset($_SESSION['amount']) ? number_format($_SESSION['amount'], 0, ',', '.') : '0'; ?></p>
        <p><strong>Pesan:</strong> <?php echo isset($_SESSION['message']) ? $_SESSION['message'] : 'Tidak ada pesan'; ?></p>

        <button id="pay-button">Bayar Sekarang</button>

        <script type="text/javascript">
            document.getElementById('pay-button').onclick = function(){
                var name = '<?php echo $_SESSION['name']; ?>';
                var email = '<?php echo $_SESSION['email']; ?>';
                var amount = '<?php echo $_SESSION['amount']; ?>';
                var message = '<?php echo $_SESSION['message']; ?>';

                fetch('payment_gateway', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'name=' + encodeURIComponent(name) + '&email=' + encodeURIComponent(email) + '&amount=' + encodeURIComponent(amount) + '&message=' + encodeURIComponent(message)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.snapToken) {
                        snap.pay(data.snapToken, {
                            onSuccess: function(result) {
                                console.log('Success:', result);
                                window.location.href = "process?order_id=" + result.order_id;
                            },
                            onPending: function(result) {
                                console.log('Pending:', result);
                                window.location.href = "pending";
                            },
                            onError: function(result) {
                                console.log('Error:', result);
                                alert('Pembayaran gagal!');
                            }
                        });
                    } else {
                        alert('Token tidak ditemukan. Cek kembali server.');
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('Terjadi kesalahan pada fetch request.');
                });
            };
        </script>

        <center>
            <a href="index">Ubah Data</a>
        </center>
    </div>
</body>
</html>
