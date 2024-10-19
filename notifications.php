<?php
session_start();

// Path to the JSON file
$file = 'donations.json';

// Read the latest donation from the JSON file if it exists
$latestDonation = [
    'name' => 'Anonymous',
    'amount' => '0',
    'message' => 'No message provided',
    'order_id' => '',
];

if (file_exists($file)) {
    $donations = json_decode(file_get_contents($file), true);
    if (!empty($donations)) {
        $latestDonation = end($donations); // Get the latest donation
    }
}

// Retrieve details from the latest donation
$name = $latestDonation['name'] ?? 'Anonymous';
$amount = $latestDonation['amount'] ?? '0';
$message = $latestDonation['message'] ?? 'No message provided';
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
            background: transparent; /* For OBS overlay */
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background: rgba(255, 255, 255, 0.9); /* Semi-transparent background */
            border-radius: 20px;
            padding: 40px;
            max-width: 900px; /* Increased width */
            width: 90%;
            text-align: center;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .logo-container {
            margin-bottom: 20px;
        }
        .circle-logo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 3px solid #4caf50; /* Green border */
        }
        h1 {
            color: #4caf50;
            font-size: 48px; /* Larger font size for visibility */
            margin-bottom: 20px;
        }
        p {
            font-size: 24px; /* Larger font size */
            line-height: 1.6;
            color: #333;
            margin: 15px 0;
        }
        .highlight {
            color: #4caf50;
            font-weight: bold;
        }
        .message {
            font-style: italic;
            color: #666;
            font-size: 22px;
            margin-top: 20px;
            background: #f4f4f4;
            border-radius: 10px;
            padding: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <img src="public/img/logo-nyawer2-removebg-preview.png" alt="Logo Nyaweria" class="circle-logo">
        </div>
        <h1>Nyaweria!!!!</h1>
        <div class="details">
            <p><strong class="highlight"><?php echo htmlspecialchars($name); ?></strong> mengirim dukungan sebesar <strong class="highlight">Rp <?php echo number_format($amount, 0, ',', '.'); ?></strong></p>
            <p class="message">"<?php echo htmlspecialchars($message); ?>"</p>
        </div>
    </div>
</body>
</html>
