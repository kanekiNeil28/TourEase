<?php
// --- ABSOLUTELY NOTHING ABOVE THIS LINE (no spaces, no BOM) ---

/* TURN OFF raw error output for this API */
ini_set('display_errors', 0);          // disable HTML errors in JSON
error_reporting(E_ALL);                // still log them on server

header('Content-Type: application/json; charset=utf-8');

require_once '../db_connect.php';

$activities = [];

try {
    $stmt = $conn->prepare(
        "SELECT ActivityID, ActivityName, ActivityImage
         FROM   activities"
    );
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_assoc()) {
        $activities[] = [
            'ActivityID'    => $row['ActivityID'],
            'ActivityName'  => $row['ActivityName'],
            // If you store PNGs change image/png
            'ActivityImage' => 'data:image/jpeg;base64,' .
                               base64_encode($row['ActivityImage'])
        ];
    }

    echo json_encode($activities, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
} catch (Throwable $e) {
    /* send a minimal error object that won't break JSON parsing */
    http_response_code(500);
    echo json_encode(['error' => 'Server error, try again later']);
}
$conn->close();
exit;                 // <‑‑ make 100 % sure NOTHING is echoed after here
