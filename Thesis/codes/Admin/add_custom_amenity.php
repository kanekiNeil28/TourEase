<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
require_once __DIR__ . '/../db_connect.php';
$data = json_decode(file_get_contents("php://input"), true);
$name = trim($data['name']);
$destinationId = intval($data['destinationId']);

$stmt = $conn->prepare("INSERT INTO amenities (Amenities) VALUES (?)");
$stmt->bind_param("s", $name);
$stmt->execute();
$newAmenityID = $conn->insert_id;

$stmt2 = $conn->prepare("INSERT INTO amenities_destination (AmenitiesID, DestinationID) VALUES (?, ?)");
$stmt2->bind_param("ii", $newAmenityID, $destinationId);
$stmt2->execute();

echo json_encode(["message" => "$name amenity added successfully."]);
?>
