<?php
// get_news.php
header('Content-Type: application/json');
require_once __DIR__ . '/../db_connect.php';   // <-- your mysqli $conn

$sql = "SELECT NewsID, NewsTitle, NewsHeadline, NewsImage, NewsDate
        FROM news
        ORDER BY NewsDate DESC";

$res   = $conn->query($sql);
$items = [];

if ($res && $res->num_rows) {
    while ($row = $res->fetch_assoc()) {
        $items[] = [
            'NewsID'       => (int) $row['NewsID'],
            'NewsTitle'    => $row['NewsTitle'],
            'NewsHeadline' => $row['NewsHeadline'],
            // longblob → base64 so it’s display-ready in <img src="">
            'NewsImage'    => 'data:image/jpeg;base64,' . base64_encode($row['NewsImage']),
            // handy if you want to show “5 h ago”, etc.
            'NewsDate'     => $row['NewsDate'],
        ];
    }
}

echo json_encode([
    'success' => true,
    'data'    => $items
]);
