<?php
require_once '../db_connect.php';

header('Content-Type: application/json');

try {
    $query = "SELECT d.DestinationID, d.DestinationName, d.DestinationInfo, d.DestinationImage 
              FROM destination d
              ORDER BY d.DestinationName";
    
    $result = $conn->query($query);
    
    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }
    
    $destinations = [];
    while ($row = $result->fetch_assoc()) {
        $row['ImageBase64'] = base64_encode($row['DestinationImage']);
        unset($row['DestinationImage']); // Remove the raw blob data
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