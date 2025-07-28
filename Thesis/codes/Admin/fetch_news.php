<?php
// fetch_news.php
require_once '../db_connect.php';

$sql = "SELECT * FROM news ORDER BY NewsDate DESC";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $id = $row['NewsID'];
    $title = htmlspecialchars($row['NewsTitle']);
    $headline = htmlspecialchars($row['NewsHeadline']);
    $body = htmlspecialchars($row['NewsBody']);
    $date = date("F j, Y", strtotime($row['NewsDate']));
    $image = base64_encode($row['NewsImage']);

    echo "
        <div class='news-card'>
            <img src='data:image/jpeg;base64,$image' alt='$title Image' class='news-card-image'>
            <div class='news-card-content'>
                <h1 class='news-card-title'>$title</h1>
                <p class='news-card-headline'>$headline</p>
                <p class='news-body-text'>$body</p>
                <div class='news-card-meta'>
                    <span class='news-card-date'>📅 $date</span>
                    <div class='news-card-actions'>
                        <span class='material-icons edit-icon action-icon' onclick='editNews($id)'>edit</span>
                        <span class='material-icons delete-icon action-icon' onclick='deleteNews($id)'>delete</span>
                    </div>
                </div>
            </div>
        </div>
    ";
}

$conn->close();
?>