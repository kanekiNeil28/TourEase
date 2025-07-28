<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

require_once __DIR__ . '/../db_connect.php';

$response = ['success' => false, 'message' => ''];

try {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        throw new Exception('Invalid destination ID');
    }

    $destinationId = intval($_GET['id']);
    
    $stmt = $conn->prepare("SELECT DestinationID, DestinationLocation, DestinationName, DestinationInfo, 
                        DestinationImage, DestinationLatitude, DestinationLongitude 
                        FROM destination WHERE DestinationID = ?");
    $stmt->bind_param("i", $destinationId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Destination not found');
    }
    
    $destination = $result->fetch_assoc();
    
    // Handle image data
    if ($destination['DestinationImage']) {
        $destination['DestinationImage'] = base64_encode($destination['DestinationImage']);
    }
    
    $response['success'] = true;
    $response['data'] = $destination;
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
} finally {
    if (isset($conn)) $conn->close();
    echo json_encode($response);
}
?>