<?php
require_once __DIR__ . '/../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $destinationId = intval($_POST['destinationId']);

    if (!isset($_FILES['images']) || count($_FILES['images']['name']) === 0) {
        echo json_encode(['success' => false, 'message' => 'No images uploaded.']);
        exit;
    }

    $uploadedCount = count($_FILES['images']['name']);
    if ($uploadedCount > 3) {
        echo json_encode(['success' => false, 'message' => 'You can upload up to 3 images only.']);
        exit;
    }

    for ($i = 0; $i < $uploadedCount; $i++) {
        $imageTmpPath = $_FILES['images']['tmp_name'][$i];
        if (is_uploaded_file($imageTmpPath)) {
            $imageData = file_get_contents($imageTmpPath);

            $stmt = $conn->prepare("INSERT INTO destination_image (DestinationID, DestinationImageImage) VALUES (?, ?)");
            $null = NULL;
            $stmt->bind_param("ib", $destinationId, $null);
            $stmt->send_long_data(1, $imageData);
            $stmt->execute();
            $stmt->close();
        }
    }

    echo json_encode(['success' => true, 'message' => 'Images uploaded successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
