<?php
header('Content-Type: application/json');

// Include your database connection
require_once '../db_connect.php';

$destinationId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Prepare and execute query
$stmt = $conn->prepare("SELECT DestinationName, DestinationLatitude, DestinationLongitude FROM destination WHERE DestinationID = ?");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Database prepare error: ' . $conn->error]);
    exit;
}

$stmt->bind_param("i", $destinationId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $destination = $result->fetch_assoc();
    
    // Validate and format the coordinates
    $latitude = is_numeric($destination['DestinationLatitude']) ? (float)$destination['DestinationLatitude'] : null;
    $longitude = is_numeric($destination['DestinationLongitude']) ? (float)$destination['DestinationLongitude'] : null;
    
    if ($latitude === null || $longitude === null) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid coordinate format in database'
        ]);
        exit;
    }

    echo json_encode([
        'success' => true,
        'DestinationName' => $destination['DestinationName'],
        'latitude' => $latitude,
        'longitude' => $longitude
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Destination not found']);
}

$stmt->close();
$conn->close();
?>