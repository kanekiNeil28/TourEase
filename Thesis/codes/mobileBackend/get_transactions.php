<?php
require 'db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input")); // same as your insert
$accountId = $data->accountId ?? 0;

if (!$accountId) {
    echo json_encode(['status' => 'error', 'message' => 'Missing or invalid account ID']);
    exit;
}

// Fetch transaction data for the logged-in user
$query = "
    SELECT 
        t.TransactionID AS id,
        DATE(t.TransactionDate) AS date,
        t.GuestName AS name,
        (t.GuestCountUndiscounted + t.GuestCountDiscounted) AS guest_count,
        t.TotalFee AS fee
    FROM transaction t
    WHERE t.AccountID = ?
    ORDER BY t.TransactionDate DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $accountId);
$stmt->execute();
$result = $stmt->get_result();

$transactions = [];

while ($row = $result->fetch_assoc()) {
    $transactions[] = [
        "id" => $row['id'],
        "date" => $row['date'],
        "name" => $row['name'],
        "guest_count" => $row['guest_count'],
        "fee" => "₱" . number_format($row['fee'], 2),
        "status" => "Collected",
        "type" => "Collection",
        "payment" => "Paid"
    ];
}

echo json_encode(['status' => 'success', 'transactions' => $transactions]);
