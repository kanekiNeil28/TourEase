<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Adjust if needed
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require 'db.php'; // include database connection

// Read incoming POST data
$data = json_decode(file_get_contents("php://input"), true);

$identifier = $data['email'] ?? ''; // could be email or username
$password = $data['password'] ?? '';

if (empty($identifier) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Email/username and password are required"]);
    exit;
}

// Query for email or username
$stmt = $conn->prepare("SELECT * FROM accounts WHERE AccountEmail = ? OR AccountUsername = ?");
$stmt->bind_param("ss", $identifier, $identifier);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $account = $result->fetch_assoc();

    // If you later hash passwords, use password_verify here.
    if ($password === $account['AccountPassword']) {
        // Login success, return user info except password
        unset($account['AccountPassword']); // Do not expose password
        echo json_encode([
            "status" => "success",
            "message" => "Login successful",
            "account" => $account
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Wrong username or password"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Wrong username or password"]);
}

$stmt->close();
$conn->close();
?>
