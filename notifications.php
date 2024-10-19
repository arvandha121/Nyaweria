<?php
session_start();

// Path to the JSON file
$file = 'donations.json';

// Read the latest donation from the JSON file if it exists
$latestDonation = [
    'name' => '',
    'amount' => '',
    'message' => '',
    'order_id' => '',
];

if (file_exists($file)) {
    $donations = json_decode(file_get_contents($file), true);
    if (!empty($donations)) {
        $latestDonation = end($donations); // Get the latest donation
    }
}

// Retrieve details from the latest donation
$name = $latestDonation['name'] ?? '';
$amount = $latestDonation['amount'] ?? '';
$message = $latestDonation['message'] ?? '';
$order_id = $latestDonation['order_id'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Donasi</title>
    <link rel="stylesheet" href="public/css/notifications.css">
    <style>
        body {
            background: transparent; /* For OBS overlay, make the background transparent */
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .logo-container {
            text-align: center;
            margin-top: 30px;
        }
        .circle-logo {
            width: 100px;
            border-radius: 50%;
        }
        h1 {
            text-align: center;
            color: #4caf50; /* Green color */
            font-size: 36px;
        }
        p {
            text-align: center;
            font-size: 18px;
            color: #555;
        }
        .details {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="logo-container">
        <img src="public/img/logo-nyawer2-removebg-preview.png" alt="Logo Nyaweria" class="circle-logo">
    </div>
    <h1>Nyaweria!!!!</h1>
    <div class="details">
        <p><strong><?php echo htmlspecialchars($name); ?></strong> mengirim dukungan sebesar <strong>Rp <?php echo number_format($amount, 0, ',', '.'); ?></strong></p>
        <p><strong>Pesan:</strong> "<?php echo htmlspecialchars($message); ?>"</p>
        <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order_id); ?></p>
    </div>
</body>
</html>
