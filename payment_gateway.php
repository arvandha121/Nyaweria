<?php
require_once 'vendor/autoload.php';
require_once 'database/db.php';
require_once 'midtrans_config.php';

$name = $_POST['name'];
$email = $_POST['email'];
$amount = $_POST['amount'];
$message = $_POST['message'];
$orderId = uniqid('DONATION_');

// Details for Midtrans
$transactionDetails = [
    'order_id' => $orderId,
    'gross_amount' => (int) $amount,
];
$customerDetails = [
    'first_name' => $name,
    'email' => $email,
];
$itemDetails = [
    [
        'id' => 'donation',
        'price' => (int) $amount,
        'quantity' => 1,
        'name' => 'Donasi ' . $name
    ],
];
$transaction = [
    'transaction_details' => $transactionDetails,
    'customer_details' => $customerDetails,
    'item_details' => $itemDetails,
];

try {
    $snapToken = \Midtrans\Snap::getSnapToken($transaction);

    // Save transaction details to payments table
    $db = getDbConnection();
    $query = "INSERT INTO payments (snap_token, amount, status) VALUES (:snap_token, :amount, :status)";
    $stmt = $db->prepare($query);
    $stmt->execute([
        ':snap_token' => $snapToken,
        ':amount' => $amount,
        ':status' => 'pending'
    ]);

    echo json_encode(['snapToken' => $snapToken]);
} catch (Exception $e) {
    error_log('Midtrans Error: ' . $e->getMessage());
    echo json_encode(['error' => $e->getMessage()]);
}
