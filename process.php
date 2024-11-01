<?php
session_start();
require_once 'vendor/autoload.php';

// \Midtrans\Config::$serverKey = 'Mid-server-ke4_kEfnPpyuUCir970j_H2K'; //live
\Midtrans\Config::$serverKey = 'SB-Mid-server-ZXlFLwWl4lw82d9N6AFdxozy'; //demo
\Midtrans\Config::$isProduction = false; // true is live, and false is sandbox
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

if (!isset($_GET['order_id'])) {
    header('Location: index');
    exit();
}

$order_id = htmlspecialchars($_GET['order_id']);
$paymentSuccess = false;

try {
    $status = \Midtrans\Transaction::status($order_id);

    if ($status->transaction_status == 'settlement' || $status->transaction_status == 'capture') {
        // Retrieve donation details from the session
        $name = $_SESSION['name'] ?? 'Anonymous';
        $amount = $_SESSION['amount'] ?? '0';
        $email = $_SESSION['email'] ?? '';
        $message = $_SESSION['message'] ?? 'No message provided';
        $timestamp = date('c');

        // Prepare the new donation entry
        $newDonation = [
            "name" => $name,
            "email" => $email,
            "amount" => $amount,
            "message" => $message,
            "timestamp" => $timestamp,
            "order_id" => $order_id
        ];

        // Read existing donations
        $file = 'donations.json';
        $donations = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

        // Append the new donation
        $donations[] = $newDonation;

        // Save back to the JSON file
        file_put_contents($file, json_encode($donations, JSON_PRETTY_PRINT));

        // Clear session data to prevent duplicates
        unset($_SESSION['name'], $_SESSION['amount'], $_SESSION['email'], $_SESSION['message']);

        $paymentSuccess = true;
    }
} catch (Exception $e) {
    $error = "Terjadi kesalahan saat memverifikasi status pembayaran: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Sukses</title>
    <link rel="stylesheet" href="public/css/process.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }
        .container {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 700px;
            width: 90%;
            text-align: center;
        }
        .logo-container {
            margin-bottom: 20px;
        }
        .circle-logo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
        }
        h1 {
            color: #4caf50;
            font-size: 32px;
            margin-bottom: 15px;
        }
        p {
            font-size: 18px;
            line-height: 1.8;
            margin: 10px 0;
        }
        .highlight {
            color: #4caf50;
            font-weight: bold;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 15px 30px;
            background-color: #4caf50;
            color: #fff;
            font-size: 17px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .back-link:hover {
            background-color: #45a049;
        }
        .error {
            color: #d9534f;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <img src="public/img/logo-nyawer2-removebg-preview.png" alt="Logo Nyaweria" class="circle-logo">
        </div>
        <?php if ($paymentSuccess): ?>
            <h1>Pembayaran Anda Sukses</h1>
            <p style="font-size: 15px">Order ID: <span class="highlight"><?php echo htmlspecialchars($order_id); ?></span></p>
            <p>Terima kasih <span class="highlight"><?php echo htmlspecialchars($name); ?></span>, atas dukungan Anda sebesar <span class="highlight">Rp <?php echo number_format($amount, 0, ',', '.'); ?></span>!</p>
            <p>Pesan Anda: <em>"<?php echo htmlspecialchars($message); ?>"</em></p>
        <?php else: ?>
            <h1>Pembayaran Gagal</h1>
            <p class="error"><?php echo isset($error) ? htmlspecialchars($error) : 'Pembayaran belum selesai atau gagal.'; ?></p>
        <?php endif; ?>
        <a href="index" class="back-link">Kembali ke Halaman Utama</a>
    </div>
</body>
</html>
