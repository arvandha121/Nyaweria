<?php
session_start();

$file = 'donations.json';

$latestDonation = [
    'name' => 'Anonymous',
    'amount' => '0',
    'message' => 'No message provided',
    'order_id' => '',
];

if (file_exists($file)) {
    $donations = json_decode(file_get_contents($file), true);
    if (!empty($donations)) {
        $latestDonation = end($donations);
    }
}

$name = $latestDonation['name'] ?? 'Anonymous';
$amount = $latestDonation['amount'] ?? '0';
$message = $latestDonation['message'] ?? 'No message provided';
$order_id = $latestDonation['order_id'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible="IE=edge">
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
            <p><strong class="highlight"><?php echo htmlspecialchars($name); ?></strong> memberi dukungan <strong class="highlight">Rp <?php echo number_format($amount, 0, ',', '.'); ?></strong></p>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const notification = document.getElementById('notification');
            const audio = new Audio('notif/kobo_donation.mp3');
            audio.volume = 1.0;

            // Function to show the notification and play sound
            function showNotification() {
                notification.classList.add('visible');
                audio.play().catch(error => console.error('Audio playback error:', error));
                
                // Wait for the audio to finish before starting the speech synthesis
                audio.addEventListener('ended', () => {
                    readMessage();
                });

                setTimeout(() => {
                    notification.classList.remove('visible');
                }, 8000);
            }

            // Function to read the message using SpeechSynthesis
            function readMessage() {
                const name = "<?php echo htmlspecialchars($name); ?>";
                const amount = "<?php echo number_format($amount, 0, ',', '.'); ?>";
                const message = "<?php echo htmlspecialchars($message); ?>";

                const text = `${name} memberi dukungan sebesar Rp ${amount}. Pesan: ${message}`;
                const speech = new SpeechSynthesisUtterance(text);

                speech.lang = 'id-ID'; // Set language to Indonesian
                speech.rate = 1; // Adjust speed if needed (1 is normal speed)
                speech.pitch = 1; // Adjust pitch if needed (1 is default)

                window.speechSynthesis.speak(speech);
            }

            // Automatically show the notification
            showNotification();
        });
    </script>
</body>
</html>
