<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = htmlspecialchars($_POST['name']);
        $amount = htmlspecialchars($_POST['amount']);
        $message = htmlspecialchars($_POST['message']);
        
        // Create an array with the notification data
        $notificationData = [
            'name' => $name,
            'amount' => $amount,
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s')
        ];

        // Save the data to a JSON file
        file_put_contents('notification.json', json_encode($notificationData, JSON_PRETTY_PRINT));

        // Respond with a success message
        echo json_encode(['status' => 'success', 'message' => 'Notification data updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
