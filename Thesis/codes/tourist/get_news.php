<?php
header('Content-Type: application/json');
require_once '../db_connect.php';

$sql = "SELECT NewsID, NewsTitle, NewsHeadline, NewsBody, NewsImage, NewsDate FROM news";


$res   = $conn->query($sql);
$items = [];

if ($res && $res->num_rows) {
    while ($row = $res->fetch_assoc()) {
        $items[] = [
    'NewsID'       => (int) $row['NewsID'],
    'NewsTitle'    => $row['NewsTitle'],
    'NewsHeadline' => $row['NewsHeadline'],
    'NewsBody'     => $row['NewsBody'], // ✅ Add this line
    'NewsImage'    => 'data:image/jpeg;base64,' . base64_encode($row['NewsImage']),
    'NewsDate'     => $row['NewsDate'],
];

    }
}

echo json_encode([
    'success' => true,
    'data'    => $items
]);

