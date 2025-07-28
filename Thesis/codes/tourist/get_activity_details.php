<?php
// NOTHING before <?php (no BOM/blank lines)

header('Content-Type: application/json; charset=utf-8');
require_once '../db_connect.php';

$activityId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$out = ['success' => false, 'message' => 'Invalid ID'];

try {
    /* 1 — basic activity data */
    $stmt = $conn->prepare(
        "SELECT ActivityName, ActivityImage
         FROM   activities
         WHERE  ActivityID = ?"
    );
    $stmt->bind_param("i", $activityId);
    $stmt->execute();
    $act = $stmt->get_result()->fetch_assoc();

    if ($act) {
        /* 2 — destinations that offer this activity */
        $stmt = $conn->prepare(
            "SELECT d.DestinationID, d.DestinationName
             FROM   destination d
             JOIN   activities_destination ad  ON ad.DestinationID = d.DestinationID
             WHERE  ad.ActivityID = ?"
        );
        $stmt->bind_param("i", $activityId);
        $stmt->execute();
        $destRes = $stmt->get_result();

        $destinations = [];
        while ($row = $destRes->fetch_assoc()) {
            $destinations[] = $row;
        }

        $out = [
            'success'       => true,
            'ActivityName'  => $act['ActivityName'],
            'ActivityImage' => 'data:image/jpeg;base64,' .
                               base64_encode($act['ActivityImage']),
            'Destinations'  => $destinations
        ];
    } else {
        $out['message'] = 'Activity not found';
    }
} catch (Throwable $e) {
    $out = ['success' => false, 'message' => 'Server error'];
}

echo json_encode($out, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
$conn->close();
exit;
