<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

require_once __DIR__ . '/../db_connect.php';

// Decode incoming JSON payload
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['destinationId'], $data['selectedAmenities'])) {
    echo json_encode(["error" => "Invalid request"]);
    exit;
}

$destinationId = intval($data['destinationId']);
$amenityIds = $data['selectedAmenities'];

// Ensure submitted amenities are integers
$submittedAmenityIds = array_map('intval', $amenityIds);

// Fetch current amenity IDs from database
$currentAmenityIds = [];
$result = $conn->query("SELECT AmenitiesID FROM amenities_destination WHERE DestinationID = $destinationId");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $currentAmenityIds[] = intval($row['AmenitiesID']);
}
    $result->free();
}

// Sort both arrays before comparison
sort($submittedAmenityIds);
sort($currentAmenityIds);

// If same, no changes needed
if ($submittedAmenityIds === $currentAmenityIds) {
    echo json_encode(["message" => "Amenities already up to date."]);
    exit;
}

// Remove existing amenities
$conn->query("DELETE FROM amenities_destination WHERE DestinationID = $destinationId");

// Insert new amenities
$stmt = $conn->prepare("INSERT INTO amenities_destination (AmenitiesID, DestinationID) VALUES (?, ?)");
foreach ($submittedAmenityIds as $aid) {
    $stmt->bind_param("ii", $aid, $destinationId);
    $stmt->execute();
}
$stmt->close();

echo json_encode(["message" => "Amenities updated successfully."]);
?>
