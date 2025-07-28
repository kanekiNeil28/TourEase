<?php
require_once '../db_connect.php'; // Go up one folder from 'tourist' to 'codes'

header('Content-Type: application/json');

$response = [
  'success' => false,
  'data' => []
];

$sql = "SELECT DestinationID, DestinationName, DestinationLocation FROM destination";
$result = $conn->query($sql);

if ($result) {
    $locations = [];
    while ($row = $result->fetch_assoc()) {
        $locations[] = $row;
    }
    $response['success'] = true;
    $response['data'] = $locations;
} else {
    $response['message'] = 'Error executing query: ' . $conn->error;
}

echo json_encode($response);
?>
