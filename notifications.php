<?php
session_start();
require_once 'database/db.php'; // Pastikan koneksi ke database

// Ambil donasi terbaru dari database
$latestDonation = [
    'name' => 'Anonymous',
    'amount' => '0',
    'message' => 'No message provided',
    'order_id' => '',
];

try {
    $db = getDbConnection();
    $stmt = $db->query("SELECT name, amount, message, order_id FROM donations ORDER BY timestamp DESC LIMIT 1");
    $latestDonation = $stmt->fetch();

    if (!$latestDonation) {
        $latestDonation = [
            'name' => 'Anonymous',
            'amount' => '0',
            'message' => 'No message provided',
            'order_id' => '',
        ];
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
}

$name = htmlspecialchars($latestDonation['name']);
$amount = htmlspecialchars($latestDonation['amount']);
$message = htmlspecialchars($latestDonation['message']);
$order_id = htmlspecialchars($latestDonation['order_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Donasi</title>
    <link rel="stylesheet" href="public/css/notifications.css">
</head>
<body>
    <div class="container" id="notification">
        <div class="logo-container">
            <img src="public/img/logo-nyawer2-removebg-preview.png" alt="Logo Nyaweria" class="circle-logo">
        </div>
        <h1>Nyaweria!!!!</h1>
        <div class="details">
            <p><strong class="highlight" id="donor-name"><?php echo $name; ?></strong> memberi dukungan <strong class="highlight" id="donation-amount">Rp <?php echo number_format($amount, 0, ',', '.'); ?></strong></p>
            <p class="message" id="donation-message"><?php echo $message; ?></p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let lastShownOrderId = localStorage.getItem('lastShownOrderId') || '';
            const notification = document.getElementById('notification');
            const donorNameElement = document.getElementById('donor-name');
            const donationAmountElement = document.getElementById('donation-amount');
            const donationMessageElement = document.getElementById('donation-message');
            const audio = new Audio('notif/kobo_donation.mp3');
            audio.volume = 1.0;

            // Function to show the notification and play sound
            function showNotification() {
                // Prevent multiple speech instances
                window.speechSynthesis.cancel();

                notification.classList.add('visible');
                audio.play().catch(error => console.error('Audio playback error:', error));

                // Use a single listener to read the message after the audio
                audio.addEventListener('ended', () => {
                    readMessage();
                }, { once: true });

                setTimeout(() => {
                    notification.classList.remove('visible');
                }, 8000);
            }

            // Function to read the message using SpeechSynthesis
            function readMessage() {
                const text = `${donorNameElement.textContent} memberi dukungan sebesar ${donationAmountElement.textContent}. Pesan: ${donationMessageElement.textContent}`;
                const speech = new SpeechSynthesisUtterance(text);

                speech.lang = 'id-ID'; // Set language to Indonesian
                speech.rate = 1; // Adjust speed if needed (1 is normal speed)
                speech.pitch = 1; // Adjust pitch if needed (1 is default)

                window.speechSynthesis.speak(speech);
            }

            // Function to fetch the latest donation from the server
            async function fetchLatestDonation() {
                try {
                    const response = await fetch('get_latest_donation.php'); // Endpoint baru untuk menarik data terbaru
                    const latestDonation = await response.json();

                    // Check if the latest donation is different from the last shown donation
                    if (latestDonation.order_id !== lastShownOrderId) {
                        // Update the displayed values
                        donorNameElement.textContent = latestDonation.name;
                        donationAmountElement.textContent = `Rp ${new Intl.NumberFormat('id-ID').format(latestDonation.amount)}`;
                        donationMessageElement.textContent = latestDonation.message;

                        // Show the notification for the new donation
                        showNotification();

                        // Update the last shown order ID in localStorage
                        localStorage.setItem('lastShownOrderId', latestDonation.order_id);
                        lastShownOrderId = latestDonation.order_id;
                    }
                } catch (error) {
                    console.error('Error fetching donation data:', error);
                }
            }

            // Automatically check for new donations every 5 seconds
            setInterval(fetchLatestDonation, 5000);
        });
    </script>
</body>
</html>
