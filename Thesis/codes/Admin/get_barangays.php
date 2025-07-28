<?php
require_once __DIR__ . '/../db_connect.php';
$sql = "SELECT BarangayID, BarangayName FROM barangay WHERE BarangayName != 'Calatagan' ORDER BY BarangayName ASC";
$result = $conn->query($sql);

$barangays = [];

while ($row = $result->fetch_assoc()) {
    $barangays[] = $row;
}

header('Content-Type: application/json');
echo json_encode($barangays);
?>
