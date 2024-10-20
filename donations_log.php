<?php
session_start();

$file = 'payment_gateway.json';

// Check if the JSON file exists and is readable
if (!file_exists($file) || !is_readable($file)) {
    die('Payment gateway file not found or is not readable.');
}

// Read the contents of the JSON file
$payments = json_decode(file_get_contents($file), true);

// Check if decoding was successful
if (!is_array($payments)) {
    die('Error decoding payment data.');
}

// Reverse the payments array to display the newest first
$payments = array_reverse($payments);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Log</title>
    <link rel="stylesheet" href="public/css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #4caf50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        table th {
            background-color: #4caf50;
            color: #fff;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .no-data {
            text-align: center;
            margin-top: 20px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment Gateway Log</h1>
        <div id="payment-log">
            <?php if (empty($payments)): ?>
                <p class="no-data">No payment records found.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Message</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($payments as $payment): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($payment['name'] ?? 'N/A'); ?></td>
                                <td>Rp <?php echo number_format($payment['amount'] ?? 0, 0, ',', '.'); ?></td>
                                <td><?php echo htmlspecialchars($payment['message'] ?? 'No message provided'); ?></td>
                                <td><?php echo htmlspecialchars($payment['timestamp'] ?? 'N/A'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let lastFetchedData = '';

            // Function to fetch and update the payment log
            async function fetchPaymentLog() {
                try {
                    const response = await fetch('payment_gateway.json');
                    const payments = await response.json();
                    const reversedPayments = payments.reverse(); // Display the newest first

                    const currentData = JSON.stringify(reversedPayments);

                    // Update the table only if the data has changed
                    if (currentData !== lastFetchedData) {
                        lastFetchedData = currentData;

                        // Build the new table content
                        let tableContent = `<table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Message</th>
                                    <th>Timestamp</th>
                                </tr>
                            </thead>
                            <tbody>`;

                        reversedPayments.forEach(payment => {
                            tableContent += `
                                <tr>
                                    <td>${payment.name || 'N/A'}</td>
                                    <td>Rp ${new Intl.NumberFormat('id-ID').format(payment.amount || 0)}</td>
                                    <td>${payment.message || 'No message provided'}</td>
                                    <td>${payment.timestamp || 'N/A'}</td>
                                </tr>`;
                        });

                        tableContent += `</tbody></table>`;

                        // Update the payment log div with the new table content
                        document.getElementById('payment-log').innerHTML = tableContent;
                    }

                } catch (error) {
                    console.error('Error fetching payment data:', error);
                }
            }

            // Fetch the payment log every 5 seconds to update the data
            setInterval(fetchPaymentLog, 5000);
        });
    </script>
</body>
</html>
