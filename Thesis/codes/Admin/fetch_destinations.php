<?php
header('Content-Type: application/json');

try {
    require_once __DIR__ . '/../db_connect.php';
    
    $sql = "SELECT DestinationID, DestinationName, DestinationInfo, DestinationImage, DestinationLatitude, DestinationLongitude FROM destination";
    $result = $conn->query($sql);
    
    $destinations = [];
    
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Handle BLOB data if needed
            if (isset($row['DestinationImage'])) {
                $row['DestinationImage'] = base64_encode($row['DestinationImage']);
            }
            $destinations[] = $row;
        }
    }
    
    echo json_encode(['success' => true, 'data' => $destinations]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} finally {
    if (isset($conn)) $conn->close();
}
?>