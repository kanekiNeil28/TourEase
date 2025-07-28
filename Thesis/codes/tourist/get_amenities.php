<?php

require_once '../db_connect.php';

header('Content-Type: application/json');

$query = $conn->query("SELECT AmenitiesID, Amenities FROM amenities");
$amenities = $query->fetch_all(MYSQLI_ASSOC);

echo json_encode($amenities);
?>
