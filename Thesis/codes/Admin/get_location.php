<?php
require_once __DIR__ . '/../db_connect.php';

$sql = "SELECT DISTINCT DestinationLocation FROM destination WHERE DestinationLocation != '0' ORDER BY DestinationLocation ASC";
$result = $conn->query($sql);

$locations = [];

while ($row = $result->fetch_assoc()) {
    $locations[] = $row;
}

header('Content-Type: application/json');
echo json_encode($locations);
?>