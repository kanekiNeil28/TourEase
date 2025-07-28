<?php
// add_news.php
require_once '../db_connect.php';

$response = ['success' => false, 'message' => ''];

try {
    $newsId = $_POST['NewsID'] ?? null;
    $title = $_POST['NewsTitle'];
    $headline = $_POST['NewsHeadline'];
    $body = $_POST['NewsBody'];
    $dateNow = date('Y-m-d H:i:s');

    // Handle image upload
    $image = null;
    if (isset($_FILES['NewsImage']) && $_FILES['NewsImage']['error'] === UPLOAD_ERR_OK) {
        $image = file_get_contents($_FILES['NewsImage']['tmp_name']);
    }

    if ($newsId) {
        // Update existing news
        if ($image) {
            $stmt = $conn->prepare("UPDATE news SET NewsTitle=?, NewsHeadline=?, NewsBody=?, NewsImage=? WHERE NewsID=?");
            $stmt->bind_param("ssssi", $title, $headline, $body, $image, $newsId);
        } else {
            $stmt = $conn->prepare("UPDATE news SET NewsTitle=?, NewsHeadline=?, NewsBody=? WHERE NewsID=?");
            $stmt->bind_param("sssi", $title, $headline, $body, $newsId);
        }
    } else {
        // Insert new news
        if ($image) {
            $stmt = $conn->prepare("INSERT INTO news (NewsTitle, NewsHeadline, NewsBody, NewsImage, NewsDate) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $title, $headline, $body, $image, $dateNow);
            $stmt->send_long_data(3, $image);
        } else {
            $stmt = $conn->prepare("INSERT INTO news (NewsTitle, NewsHeadline, NewsBody, NewsDate) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $title, $headline, $body, $dateNow);
        }
    }

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = $newsId ? 'News updated successfully' : 'News added successfully';
    } else {
        $response['message'] = 'Database error: ' . $stmt->error;
    }

    $stmt->close();
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
?>