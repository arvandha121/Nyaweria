<?php
require_once 'vendor/autoload.php'; // Jika menggunakan Composer

// Muat environment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

\Midtrans\Config::$serverKey = $_ENV['MIDTRANS_SERVER_KEY'];
\Midtrans\Config::$isProduction = filter_var($_ENV['MIDTRANS_IS_PRODUCTION'], FILTER_VALIDATE_BOOLEAN);
\Midtrans\Config::$isSanitized = filter_var(getenv('MIDTRANS_IS_SANITIZED'), FILTER_VALIDATE_BOOLEAN);
\Midtrans\Config::$is3ds = filter_var(getenv('MIDTRANS_IS_3DS'), FILTER_VALIDATE_BOOLEAN);

// Get post data from confirm.php
$name = $_POST['name'];
$email = $_POST['email'];
$amount = $_POST['amount'];
$message = $_POST['message'];

// Generate transaction ID
$orderId = uniqid('DONATION_');

// Prepare transaction details
$transactionDetails = array(
    'order_id' => $orderId,
    'gross_amount' => (int) $amount, // Amount in IDR
);

// Log transaction details
error_log("Transaction Details: " . json_encode($transactionDetails));

// Prepare customer details
$customerDetails = array(
    'first_name' => $name,
    'email' => $email,
);

// Prepare item details (optional, could be customized)
$itemDetails = array(
    array(
        'id' => 'donation',
        'price' => (int) $amount,
        'quantity' => 1,
        'name' => 'Donasi ' . $name
    ),
);

// Prepare transaction
$transaction = array(
    'transaction_details' => $transactionDetails,
    'customer_details' => $customerDetails,
    'item_details' => $itemDetails,
);

try {
    $snapToken = \Midtrans\Snap::getSnapToken($transaction);
    error_log("Snap Token: " . $snapToken);
    
    // Save donation data to JSON file
    $donationData = [
        'name' => $name,
        'amount' => $amount,
        'message' => $message, // Optional message
        'timestamp' => date('Y-m-d H:i:s')
    ];

    // Read existing donations
    $file = 'payment_gateway.json';
    $donations = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    $donations[] = $donationData; // Add new donation
    file_put_contents($file, json_encode($donations, JSON_PRETTY_PRINT)); // Save to file

    echo json_encode(array('snapToken' => $snapToken));
} catch (Exception $e) {
    error_log('Midtrans Error: ' . $e->getMessage());
    echo json_encode(array('error' => $e->getMessage()));
}