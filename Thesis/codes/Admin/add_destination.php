<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

require_once __DIR__ . '/../db_connect.php';

$response = ['success' => false, 'message' => ''];

try {
    // Validate required fields
    if (empty($_POST['destinationLocation']) || empty($_POST['destinationName']) || empty($_POST['destinationInfo']) || 
        empty($_POST['latitude']) || empty($_POST['longitude'])) {
        throw new Exception('All fields are required');
    }

    // Validate coordinates
    $latitude = floatval($_POST['latitude']);
    $longitude = floatval($_POST['longitude']);
    if ($latitude < -90 || $latitude > 90 || $longitude < -180 || $longitude > 180) {
        throw new Exception('Invalid coordinates');
    }

    // Handle file upload
    $imageData = null;
    if (isset($_FILES['destinationImage']) && $_FILES['destinationImage']['error'] === UPLOAD_ERR_OK) {
        // Validate image
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fileInfo, $_FILES['destinationImage']['tmp_name']);
        finfo_close($fileInfo);

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($mimeType, $allowedTypes)) {
            throw new Exception('Only JPG, PNG, and GIF images are allowed');
        }

        // Read image file
        $imageData = file_get_contents($_FILES['destinationImage']['tmp_name']);
        if ($imageData === false) {
            throw new Exception('Failed to read image file');
        }
    } else {
        throw new Exception('Image upload is required');
    }

    // Prepare and execute SQL
    $stmt = $conn->prepare("INSERT INTO destination 
                           (DestinationLocation, DestinationName, DestinationInfo, DestinationImage, DestinationLatitude, DestinationLongitude) 
                           VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssbdd", 
        $_POST['destinationLocation'],
        $_POST['destinationName'],
        $_POST['destinationInfo'],
        $imageData,
        $latitude,
        $longitude
    );

    // Send null for the BLOB parameter
    $null = null;
    $stmt->send_long_data(2, $imageData);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Destination added successfully';
        $response['destinationId'] = $stmt->insert_id;
    } else {
        throw new Exception('Failed to add destination: ' . $stmt->error);
    }

    $stmt->close();
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
} finally {
    if (isset($conn)) $conn->close();
    echo json_encode($response);
}
?>