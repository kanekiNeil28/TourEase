<?php
require_once '../db_connect.php';
header('Content-Type: application/json');

$selectedAmenities = $_POST['amenities'] ?? [];

try {
    if (empty($selectedAmenities)) {
        echo json_encode([
            'success' => true,
            'data' => [],
            'message' => 'No amenities selected'
        ]);
        exit;
    }

    $placeholders = implode(',', array_fill(0, count($selectedAmenities), '?'));
    $sql = "
        SELECT DISTINCT d.DestinationID, d.DestinationName, d.DestinationInfo, d.DestinationImage
        FROM destination d
        JOIN amenities_destination ad ON d.DestinationID = ad.DestinationID
        WHERE ad.AmenitiesID IN ($placeholders)
    ";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param(str_repeat('i', count($selectedAmenities)), ...$selectedAmenities);
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }

    $result = $stmt->get_result();
    $destinations = [];

    while ($row = $result->fetch_assoc()) {
        $row['ImageBase64'] = base64_encode($row['DestinationImage']);
        unset($row['DestinationImage']);
        $destinations[] = $row;
    }

    echo json_encode([
        'success' => true,
        'data' => $destinations
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
