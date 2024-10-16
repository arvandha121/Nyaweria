<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $amount = htmlspecialchars($_POST['amount']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Dukungan</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-Q7g78xXsc5ZzWo-X"></script> 
</head>
<body>
    <div class="container">
        <h1>Konfirmasi Dukungan Anda</h1>
        <p><strong>Nama:</strong> <?php echo $name; ?></p>
        <p><strong>Email:</strong> <?php echo $email; ?></p>
        <p><strong>Jumlah Nominal:</strong> Rp <?php echo number_format($amount, 0, ',', '.'); ?></p>
        <p><strong>Pesan:</strong> <?php echo $message; ?></p>

        <button id="pay-button">Bayar Sekarang</button>

        <script type="text/javascript">
            // Get Snap token from PHP backend
            document.getElementById('pay-button').onclick = function(){
                var name = '<?php echo $name; ?>';
                var email = '<?php echo $email; ?>';
                var amount = '<?php echo $amount; ?>';
                var message = '<?php echo $message; ?>';

                fetch('payment_gateway.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'name=' + name + '&email=' + email + '&amount=' + amount + '&message=' + message
                })
                .then(response => response.json())
                .then(data => {
                    if (data.snapToken) {
                        snap.pay(data.snapToken, {
                            onSuccess: function(result) {
                                console.log('Success:', result);
                                window.location.href = "success.php";  // Redirect to success page
                            },
                            onPending: function(result) {
                                console.log('Pending:', result);
                                window.location.href = "pending.php";  // Redirect to pending page
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
            <a href="index.php">Ubah Data</a>
        </center>
    </div>
</body>
</html>
