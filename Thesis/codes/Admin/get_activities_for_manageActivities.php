<?php
require_once __DIR__ . '/../db_connect.php';

header('Content-Type: application/json');

try {
    // Query to get all activities
    $query = "SELECT ActivityID, ActivityName, ActivityImage FROM activities";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    $activities = [];
    while ($row = $result->fetch_assoc()) {
        // Convert blob image to base64 if it exists
        if ($row['ActivityImage']) {
            $row['ActivityImage'] = base64_encode($row['ActivityImage']);
        }
        $activities[] = $row;
    }

    echo json_encode($activities);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

$conn->close();
?>