<?php
// Database credentials
$host = 'localhost';
$user = 'root';
$password = ''; // change if your MySQL has a password
$database = 'tourease';

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character set to utf8mb4 for proper encoding
$conn->set_charset("utf8mb4");
?>