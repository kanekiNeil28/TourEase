<?php
require_once '../db_connect.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

$name = $data->name ?? '';
$rating = $data->rating ?? 0;
$destinationId = $data->destinationId ?? 0;

if (!$name || !$rating || !$destinationId) {
    echo json_encode(['status' => 'error', 'message' => 'Missing data']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO destination_ratings (DestinationID, Ratings, RaterName) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $destinationId, $rating, $name);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to insert rating']);
}
?>
