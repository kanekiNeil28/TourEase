<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
require_once __DIR__ . '/../db_connect.php';

$response = ['success' => false, 'message' => ''];

try {
    // Get the raw JSON input
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['destinationId']) || !is_numeric($data['destinationId'])) {
        throw new Exception('Invalid or missing destination ID.');
    }

    $destinationId = intval($data['destinationId']);

    // Check if destination exists
    $checkStmt = $conn->prepare("SELECT DestinationID FROM destination WHERE DestinationID = ?");
    $checkStmt->bind_param("i", $destinationId);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception('Destination not found.');
    }
    $checkStmt->close();

    // Delete destination
    $deleteStmt = $conn->prepare("DELETE FROM destination WHERE DestinationID = ?");
    $deleteStmt->bind_param("i", $destinationId);

    if ($deleteStmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Destination deleted successfully.';
    } else {
        throw new Exception('Failed to delete destination: ' . $deleteStmt->error);
    }

    $deleteStmt->close();

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
} finally {
    if (isset($conn)) $conn->close();
    echo json_encode($response);
}
