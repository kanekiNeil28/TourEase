<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db_connect.php';

$destinationId = isset($_GET['destinationId']) ? intval($_GET['destinationId']) : 0;

// Fetch all activities
$allActivities = [];
$allQuery = "SELECT ActivityID, ActivityName FROM activities";
$allResult = $conn->query($allQuery);

if ($allResult) {
    while ($row = $allResult->fetch_assoc()) {
        $allActivities[$row['ActivityID']] = $row['ActivityName'];
    }
}

// Fetch assigned activities for the destination
$assignedActivities = [];
if ($destinationId > 0) {
    $assignedQuery = "SELECT ActivityID FROM activities_destination WHERE DestinationID = ?";
    $stmt = $conn->prepare($assignedQuery);
    $stmt->bind_param("i", $destinationId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $assignedActivities[] = $row['ActivityID'];
    }
}

// Prepare final array with checked flag
$finalActivities = [];
foreach ($allActivities as $id => $name) {
    $finalActivities[] = [
        'ActivityID' => (int)$id,
        'ActivityName' => $name,
        'checked' => in_array($id, $assignedActivities)
    ];
}

echo json_encode($finalActivities);
