<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Sukses</title>
    <link rel="stylesheet" href="public/css/process.css">
</head>
<body>
    <div class="logo-container">
        <img src="public/img/logo-nyawer2-removebg-preview.png" alt="Logo Nyaweria" class="circle-logo">
    </div>
    <h1>Pembayaran Anda Sukses</h1>
    <p>Terima kasih atas dukungan Anda!</p>
    <a href="index">Kembali ke Halaman Utama</a>

    <?php
        // Assuming you have already processed the donation data
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = htmlspecialchars($_POST['name']);
            $amount = htmlspecialchars($_POST['amount']);
            $email = htmlspecialchars($_POST['email']);
            $message = htmlspecialchars($_POST['message']);
            $timestamp = date('c'); // Current timestamp in ISO 8601 format

            // Prepare the new donation entry
            $newDonation = array(
                "name" => $name,
                "email" => $email,
                "amount" => $amount,
                "message" => $message,
                "timestamp" => $timestamp
            );

            // Read existing donations
            $file = 'donations.json';
            $donations = file_exists($file) ? json_decode(file_get_contents($file), true) : array();

            // Append the new donation
            $donations[] = $newDonation;

            // Save back to the JSON file
            file_put_contents($file, json_encode($donations, JSON_PRETTY_PRINT));

            // Redirect to notifications page after processing
            header('Location: notifications.php');
            exit();
        }
    ?>
</body>
</html>
