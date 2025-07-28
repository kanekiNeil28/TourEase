<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tourease"; // Change this to your actual DB name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed"]));
}
?>
