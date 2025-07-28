<?php
require_once __DIR__ . '/../db_connect.php'; // Adjust path if needed

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate input
        if (empty($_POST['activityName'])) {
            throw new Exception('Activity name is required');
        }

        $activityName = $_POST['activityName'];

        // Handle image upload
        $activityImage = null;
        if (isset($_FILES['activityImage']) && $_FILES['activityImage']['error'] === UPLOAD_ERR_OK) {
            $imageTmpPath = $_FILES['activityImage']['tmp_name'];
            $activityImage = file_get_contents($imageTmpPath);
        }

        // Insert into database
        $stmt = $conn->prepare("INSERT INTO activities (ActivityName, ActivityImage) VALUES (?, ?)");
        $stmt->bind_param("sb", $activityName, $null); // Use a placeholder for blob

        // Send blob separately
        $stmt->send_long_data(1, $activityImage);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            throw new Exception("Failed to insert activity: " . $stmt->error);
        }

    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
