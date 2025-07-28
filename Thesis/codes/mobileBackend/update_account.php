<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

$accountID = $data['AccountID'] ?? null;
$fullName = $data['AccountName'] ?? '';
$email = $data['AccountEmail'] ?? '';
$username = $data['AccountUsername'] ?? '';
$role = $data['AccountRole'] ?? '';

if (!$accountID) {
    echo json_encode(['status' => 'error', 'message' => 'Missing account ID']);
    exit;
}

$stmt = $conn->prepare("UPDATE accounts SET AccountName=?, AccountEmail=?, AccountUsername=?, AccountRole=? WHERE AccountID=?");
$stmt->bind_param("ssssi", $fullName, $email, $username, $role, $accountID);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Account updated successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update account']);
}

$stmt->close();
$conn->close();
?>
