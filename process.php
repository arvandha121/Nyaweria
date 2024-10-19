<?php
session_start();
require_once 'vendor/autoload.php';

\Midtrans\Config::$serverKey = 'SB-Mid-server-ZXlFLwWl4lw82d9N6AFdxozy';
\Midtrans\Config::$isProduction = false;
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
        $name = $_SESSION['name'] ?? '';
        $amount = $_SESSION['amount'] ?? '';
        $email = $_SESSION['email'] ?? '';
        $message = $_SESSION['message'] ?? '';
        $timestamp = date('c');

        // Prepare the new donation entry
        $newDonation = array(
            "name" => $name,
            "email" => $email,
            "amount" => $amount,
            "message" => $message,
            "timestamp" => $timestamp,
            "order_id" => $order_id
        );

        // Read existing donations
        $file = 'donations.json';
        $donations = file_exists($file) ? json_decode(file_get_contents($file), true) : array();

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
</head>
<body>
    <div class="logo-container">
        <img src="public/img/logo-nyawer2-removebg-preview.png" alt="Logo Nyaweria" class="circle-logo">
    </div>
    <?php if ($paymentSuccess): ?>
        <h1>Pembayaran Anda Sukses</h1>
        <p>Terima kasih, <strong><?php echo htmlspecialchars($name); ?></strong>, atas dukungan Anda sebesar Rp <?php echo number_format($amount, 0, ',', '.'); ?>!</p>
        <p>Pesan Anda: <em><?php echo htmlspecialchars($message); ?></em></p>
    <?php else: ?>
        <h1>Pembayaran Gagal</h1>
        <p><?php echo isset($error) ? htmlspecialchars($error) : 'Pembayaran belum selesai atau gagal.'; ?></p>
    <?php endif; ?>
    <a href="index" class="back-link">Kembali ke Halaman Utama</a>
</body>
</html>
