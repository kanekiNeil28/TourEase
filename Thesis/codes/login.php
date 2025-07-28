<?php
// Start the session
session_start();

// Include database connection
require_once 'db_connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");



// Set header for JSON response
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize user input
    $inputUsername = $conn->real_escape_string($_POST['username']);
    $inputPassword = $_POST['password']; // Don't escape passwords
    
    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT AccountID, AccountUsername, AccountPassword, AccountRole FROM accounts WHERE AccountUsername = ?");
    $stmt->bind_param("s", $inputUsername);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // TEMPORARY: Direct password comparison (remove for production)
        if ($inputPassword === $user['AccountPassword']) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $user['AccountID'];
            $_SESSION['username'] = $user['AccountUsername'];
            $_SESSION['role'] = $user['AccountRole'];
            
            // Return success response with role
            echo json_encode([
                'success' => true,
                'role' => $user['AccountRole']
            ]);
            exit();
        } else {
            // Password is incorrect
            echo json_encode([
                'success' => false,
                'message' => 'Invalid username or password'
            ]);
            exit();
        }
    } else {
        // User not found
        echo json_encode([
            'success' => false,
            'message' => 'Invalid username or password'
        ]);
        exit();
    }
    
    $stmt->close();
} else {
    // Not a POST request
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
    exit();
}

// Close connection
$conn->close();
?>