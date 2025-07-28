<?php
require_once __DIR__ . '/../db_connect.php'; // adjust path if needed

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (empty($_POST['activityID']) || empty($_POST['activityName'])) {
            throw new Exception('Missing required fields.');
        }

        $activityID = $_POST['activityID'];
        $activityName = $_POST['activityName'];
        $hasImage = isset($_FILES['activityImage']) && $_FILES['activityImage']['error'] === UPLOAD_ERR_OK;

        if ($hasImage) {
            $activityImage = file_get_contents($_FILES['activityImage']['tmp_name']);
            $stmt = $conn->prepare("UPDATE activities SET ActivityName = ?, ActivityImage = ? WHERE ActivityID = ?");
            $stmt->bind_param("sbi", $activityName, $null, $activityID);
            $stmt->send_long_data(1, $activityImage);
        } else {
            $stmt = $conn->prepare("UPDATE activities SET ActivityName = ? WHERE ActivityID = ?");
            $stmt->bind_param("si", $activityName, $activityID);
        }

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            throw new Exception("Update failed: " . $stmt->error);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
