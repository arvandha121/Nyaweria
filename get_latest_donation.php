<?php
require_once 'database/db.php';

try {
    $db = getDbConnection();
    $stmt = $db->query("SELECT name, amount, message, order_id FROM donations ORDER BY timestamp DESC LIMIT 1");
    $latestDonation = $stmt->fetch();

    if ($latestDonation) {
        echo json_encode([
            'name' => htmlspecialchars($latestDonation['name']),
            'amount' => $latestDonation['amount'],
            'message' => htmlspecialchars($latestDonation['message']),
            'order_id' => $latestDonation['order_id'],
        ]);
    } else {
        echo json_encode([
            'name' => 'Anonymous',
            'amount' => 0,
            'message' => 'No message provided',
            'order_id' => '',
        ]);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
