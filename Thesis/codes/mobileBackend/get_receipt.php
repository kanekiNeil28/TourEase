<?php
require 'db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));
$transactionId = $data->transactionId ?? 0;

if (!$transactionId) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid transaction ID']);
    exit;
}

$stmt = $conn->prepare("
    SELECT 
        t.GuestName AS name,
        d.DestinationName AS resort,
        t.GuestCountUndiscounted AS regularCount,
        t.GuestCountDiscounted AS discountedCount,
        t.TotalFee AS total,
        t.TransactionDate AS date,
        t.DestinationID AS destinationId
    FROM transaction t
    JOIN destination d ON t.DestinationID = d.DestinationID
    WHERE t.TransactionID = ?
");
$stmt->bind_param("i", $transactionId);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'Transaction not found']);
    exit;
}

// Calculate breakdowns
$childCount = floor($data['discountedCount'] / 2);
$pwdCount = $data['discountedCount'] - $childCount;
$regularTotal = $data['regularCount'] * 30;
$childTotal = $childCount * 24;
$pwdTotal = $pwdCount * 24;

$response = [
    'status' => 'success',
    'receipt' => [
        'name' => $data['name'],
        'resort' => $data['resort'],
        'regularCount' => $data['regularCount'],
        'childCount' => $childCount,
        'pwdCount' => $pwdCount,
        'regularTotal' => $regularTotal,
        'childTotal' => $childTotal,
        'pwdTotal' => $pwdTotal,
        'total' => $data['total'],
        'date' => $data['date'],
        'destinationId' => $data['destinationId'], // ✅ included here
    ],
];

echo json_encode($response);
