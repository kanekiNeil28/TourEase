<?php
require_once __DIR__ . '/../db_connect.php';

$location = isset($_GET['location']) ? $conn->real_escape_string($_GET['location']) : '';

if (!empty($location)) {
    // Filter by DestinationLocation
    $sql = "SELECT COUNT(*) AS total 
            FROM destination
            WHERE DestinationLocation = '$location'";
} else {
    // No filter, count all
    $sql = "SELECT COUNT(*) AS total FROM destination";
}

$result = $conn->query($sql);
$row = $result->fetch_assoc();
echo $row['total'] ?? 0;
?>