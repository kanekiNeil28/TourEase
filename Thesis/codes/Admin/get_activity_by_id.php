<?php
require_once __DIR__ . '/../db_connect.php';

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT ActivityID, ActivityName, ActivityImage FROM activities WHERE ActivityID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($activityID, $activityName, $activityImage);
    if ($stmt->fetch()) {
        echo json_encode([
            'ActivityID' => $activityID,
            'ActivityName' => $activityName,
            'ActivityImage' => base64_encode($activityImage)
        ]);
    } else {
        echo json_encode(['error' => 'Activity not found']);
    }
} else {
    echo json_encode(['error' => 'No ID specified']);
}
