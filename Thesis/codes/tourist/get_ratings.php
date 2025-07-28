<?php
require_once('../db_connect.php'); // ✅ Corrected path

header('Content-Type: application/json');

$stmt = $conn->prepare("SELECT DestinationID, AVG(ratings) AS average_rating FROM destination_ratings GROUP BY DestinationID");

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'SQL prepare failed']);
    exit;
}

$stmt->execute();
$result = $stmt->get_result();

$ratings = [];

while ($row = $result->fetch_assoc()) {
    $ratings[$row['DestinationID']] = round($row['average_rating'], 1); // Round to 1 decimal
}

echo json_encode(['success' => true, 'ratings' => $ratings]);
