<?php
require 'db.php'; // include your DB connection

$query = "SELECT DestinationName FROM destination";
$result = $conn->query($query);

$resorts = [];
while ($row = $result->fetch_assoc()) {
    $resorts[] = $row['DestinationName'];
}

echo json_encode($resorts);
?>
