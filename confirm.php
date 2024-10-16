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
    <link rel="stylesheet" href="css/confirm.css">
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="Mid-client-GC-EYUs1jQRHKFst"></script> 
</head>
<body>
    <div class="container">
        <h1>Konfirmasi Dukungan Anda</h1>
        <p><strong>Nama:</strong> <?php echo isset($name) ? $name : 'Tidak ada data'; ?></p>
        <p><strong>Email:</strong> <?php echo isset($email) ? $email : 'Tidak ada data'; ?></p>
        <p><strong>Jumlah Nominal:</strong> Rp <?php echo isset($amount) ? number_format($amount, 0, ',', '.') : '0'; ?></p>
        <p><strong>Pesan:</strong> <?php echo isset($message) ? $message : 'Tidak ada pesan'; ?></p>


        <button id="pay-button">Bayar Sekarang</button>

        <script type="text/javascript">
            // Get Snap token from PHP backend
            document.getElementById('pay-button').onclick = function(){
                var name = '<?php echo $name; ?>';
                var email = '<?php echo $email; ?>';
                var amount = '<?php echo $amount; ?>';
                var message = '<?php echo $message; ?>';

                fetch('payment_gateway', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'name=' + encodeURIComponent(name) + '&email=' + encodeURIComponent(email) + '&amount=' + encodeURIComponent(amount) + '&message=' + encodeURIComponent(message)
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Fetch Response:", data); // Log the full response
                    if (data.snapToken) {
                        snap.pay(data.snapToken, {
                            onSuccess: function(result) {
                                console.log('Success:', result);
                                window.location.href = "process";  // Redirect to success page
                            },
                            onPending: function(result) {
                                console.log('Pending:', result);
                                window.location.href = "pending";  // Redirect to pending page
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
