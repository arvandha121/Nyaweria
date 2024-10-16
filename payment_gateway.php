<?php
require_once 'vendor/autoload.php'; // Jika menggunakan Composer

// Set up Midtrans Configuration
\Midtrans\Config::$serverKey = 'SB-Mid-server-ZXlFLwWl4lw82d9N6AFdxozy';
\Midtrans\Config::$isProduction = false; // false untuk sandbox/test, true untuk live
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true; // 3D Secure payment for credit card

// Get post data from confirm.php
$name = $_POST['name'];
$email = $_POST['email'];
$amount = $_POST['amount'];

// Generate transaction ID
$orderId = uniqid('DONATION_');

// Prepare transaction details
$transactionDetails = array(
    'order_id' => $orderId,
    'gross_amount' => (int) $amount, // Amount in IDR
);

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
        'name' => 'Donasi '.$name
    ),
);

// Prepare transaction
$transaction = array(
    'transaction_details' => $transactionDetails,
    'customer_details' => $customerDetails,
    'item_details' => $itemDetails,
);

try {
    // Get Snap Payment Page URL
    $snapToken = \Midtrans\Snap::getSnapToken($transaction);
    // Log Snap Token
    error_log("Snap Token: " . $snapToken);
    echo json_encode(array('snapToken' => $snapToken));
} catch (Exception $e) {
    error_log('Midtrans Error: ' . $e->getMessage());
    echo json_encode(array('error' => $e->getMessage()));
}
