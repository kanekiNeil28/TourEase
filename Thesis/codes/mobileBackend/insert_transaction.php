<?php
require 'db.php';

$data = json_decode(file_get_contents("php://input"));

$name = $data->name;
$regular = $data->regularCount;
$discounted = $data->childCount + $data->pwdCount;
$total = $data->total;
$accountId = $data->accountId ?? 0; // Use session/account logic if needed
$destinationName = $data->resort;
$foreigner = $data->foreigner ? 1 : 0;
$booked = $data->booked ? 1 : 0;

// Get destination ID
$stmt = $conn->prepare("SELECT DestinationID FROM destination WHERE DestinationName = ?");
$stmt->bind_param("s", $destinationName);
$stmt->execute();
$result = $stmt->get_result();
$destination = $result->fetch_assoc();

if (!$destination) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid destination']);
    exit;
}
$destinationId = $destination['DestinationID'];

// Insert transaction
$stmt = $conn->prepare("INSERT INTO transaction 
    (GuestName, GuestCountUndiscounted, GuestCountDiscounted, TotalFee, TransactionDate, DestinationID, AccountID, Foreigner, Booked)
    VALUES (?, ?, ?, ?, NOW(), ?, ?, ?, ?)");
$stmt->bind_param("siidiiii", $name, $regular, $discounted, $total, $destinationId, $accountId, $foreigner, $booked);

if ($stmt->execute()) {
    $transactionId = $conn->insert_id; // ✅ Get last inserted ID
    echo json_encode([
        'status' => 'success',
        'transactionId' => $transactionId // ✅ Include it in response
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Insert failed']);
}

?>
