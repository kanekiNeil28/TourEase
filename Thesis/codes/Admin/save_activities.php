<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

require_once __DIR__ . '/../db_connect.php';

// Decode incoming JSON payload
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['destinationId'], $data['selectedActivities'])) {
    echo json_encode(["error" => "Invalid request"]);
    exit;
}

$destinationId = intval($data['destinationId']);
$activityIds = $data['selectedActivities'];

// Ensure submitted activity IDs are integers
$submittedActivityIds = array_map('intval', $activityIds);

// Fetch current activity IDs from database
$currentActivityIds = [];
$result = $conn->query("SELECT ActivityID FROM activities_destination WHERE DestinationID = $destinationId");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $currentActivityIds[] = intval($row['ActivityID']);
    }
    $result->free();
}

// Sort both arrays before comparison
sort($submittedActivityIds);
sort($currentActivityIds);

// If same, no changes needed
if ($submittedActivityIds === $currentActivityIds) {
    echo json_encode(["message" => "Activities already up to date."]);
    exit;
}

// Remove existing activities
$conn->query("DELETE FROM activities_destination WHERE DestinationID = $destinationId");

// Insert new activities
$stmt = $conn->prepare("INSERT INTO activities_destination (ActivityID, DestinationID) VALUES (?, ?)");
foreach ($submittedActivityIds as $aid) {
    $stmt->bind_param("ii", $aid, $destinationId);
    $stmt->execute();
}
$stmt->close();

echo json_encode(["message" => "Activities updated successfully."]);
