<?php
require 'db.php';

$data = json_decode(file_get_contents("php://input"));

$name = $data->name ?? '';
$date = $data->date ?? '';
$resort = $data->resort ?? '';
$total = $data->total ?? 0;

// Match resort to get DestinationID
$stmt = $conn->prepare("SELECT DestinationID FROM destination WHERE DestinationName = ?");
$stmt->bind_param("s", $resort);
$stmt->execute();
$res = $stmt->get_result();
$dest = $res->fetch_assoc();

if (!$dest) {
    echo json_encode(['status' => 'invalid']);
    exit;
}

$destinationId = $dest['DestinationID'];

$stmt = $conn->prepare("SELECT * FROM transaction 
    WHERE GuestName = ? AND DATE(TransactionDate) = ? AND DestinationID = ? AND TotalFee = ?");
$stmt->bind_param("ssii", $name, $date, $destinationId, $total);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['status' => 'valid']);
} else {
    echo json_encode(['status' => 'invalid']);
}
?>
