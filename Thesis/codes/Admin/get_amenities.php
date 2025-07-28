<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db_connect.php';

$destinationId = isset($_GET['destinationId']) ? intval($_GET['destinationId']) : 0;

$allAmenities = [];
$assignedAmenities = [];

// Fetch all amenities
$amenitiesQuery = "SELECT * FROM amenities";
$allResult = $conn->query($amenitiesQuery);

if ($allResult) {
    while ($row = $allResult->fetch_assoc()) {
        $allAmenities[$row['AmenitiesID']] = $row['Amenities'];
    }
}

// Fetch assigned amenities for the destination
$assignedQuery = "SELECT AmenitiesID FROM amenities_destination WHERE DestinationID = $destinationId";
$assignedResult = $conn->query($assignedQuery);

if ($assignedResult) {
    while ($row = $assignedResult->fetch_assoc()) {
        $assignedAmenities[] = $row['AmenitiesID'];
    }
}

// Merge and mark as checked
$finalAmenities = [];
foreach ($allAmenities as $id => $name) {
    $finalAmenities[] = [
        'AmenitiesID' => $id,
        'Amenities' => $name,
        'checked' => in_array($id, $assignedAmenities)
    ];
}

echo json_encode($finalAmenities);
