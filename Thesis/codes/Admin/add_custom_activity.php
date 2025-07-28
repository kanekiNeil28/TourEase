<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
require_once __DIR__ . '/../db_connect.php';

// Get data from JSON body
$data = json_decode(file_get_contents("php://input"), true);
$name = trim($data['name']);
$destinationId = intval($data['destinationId']);

if (empty($name)) {
    echo json_encode(["error" => "Activity name is required."]);
    exit;
}

// Insert into activities table
$stmt = $conn->prepare("INSERT INTO activities (ActivityName) VALUES (?)");
$stmt->bind_param("s", $name);
$stmt->execute();
$newActivityID = $conn->insert_id;

// Link activity to destination
$stmt2 = $conn->prepare("INSERT INTO activities_destination (ActivityID, DestinationID) VALUES (?, ?)");
$stmt2->bind_param("ii", $newActivityID, $destinationId);
$stmt2->execute();

// Response
echo json_encode(["message" => "$name activity added successfully."]);
