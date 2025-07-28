<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
require_once __DIR__ . '/../db_connect.php';

$response = ['success' => false, 'message' => ''];

try {
    // Validate inputs
    if (
        empty($_POST['destinationId']) || !is_numeric($_POST['destinationId']) ||
        empty($_POST['destinationName']) || empty($_POST['destinationInfo']) || 
        empty($_POST['latitude']) || empty($_POST['longitude'])
    ) {
        throw new Exception('All fields are required');
    }

    $destinationId = intval($_POST['destinationId']);
    $latitude = floatval($_POST['latitude']);
    $longitude = floatval($_POST['longitude']);

    if ($latitude < -90 || $latitude > 90 || $longitude < -180 || $longitude > 180) {
        throw new Exception('Invalid coordinates');
    }

    // Optional image
    $imageData = null;
    $imageUpdate = '';

    if (isset($_FILES['destinationImage']) && $_FILES['destinationImage']['error'] === UPLOAD_ERR_OK) {
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fileInfo, $_FILES['destinationImage']['tmp_name']);
        finfo_close($fileInfo);

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($mimeType, $allowedTypes)) {
            throw new Exception('Only JPG, PNG, and GIF images are allowed');
        }

        $imageData = file_get_contents($_FILES['destinationImage']['tmp_name']);
        if ($imageData === false) {
            throw new Exception('Failed to read image file');
        }

        $imageUpdate = ', DestinationImage = ?';
    }

    // Check if destination exists
    $checkStmt = $conn->prepare("SELECT DestinationID FROM destination WHERE DestinationID = ?");
    $checkStmt->bind_param("i", $destinationId);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows === 0) {
        throw new Exception('Destination not found');
    }
    $checkStmt->close();

    // Prepare update
    $sql = "UPDATE destination SET 
            DestinationName = ?,
            DestinationInfo = ?,
            DestinationLatitude = ?,
            DestinationLongitude = ?
            $imageUpdate
            WHERE DestinationID = ?";

    $stmt = $conn->prepare($sql);

    if ($imageData) {
        $stmt->bind_param("ssdbsi",
            $_POST['destinationName'],
            $_POST['destinationInfo'],
            $latitude,
            $longitude,
            $imageData,
            $destinationId
        );
        $stmt->send_long_data(4, $imageData); // index 4 = imageData
    } else {
        $stmt->bind_param("ssddi",
            $_POST['destinationName'],
            $_POST['destinationInfo'],
            $latitude,
            $longitude,
            $destinationId
        );
    }

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = ($stmt->affected_rows > 0)
            ? 'Destination updated successfully'
            : 'No changes made (same values submitted)';
    } else {
        throw new Exception('Update failed: ' . $stmt->error);
    }

    $stmt->close();
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
} finally {
    if (isset($conn)) $conn->close();
    echo json_encode($response);
}
