<?php
// get_news_details.php?id=123
header('Content-Type: application/json');
require_once __DIR__ . '/../db_connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    echo json_encode(['success'=>false,'message'=>'Invalid ID']);
    exit;
}

$stmt = $conn->prepare(
    "SELECT NewsTitle, NewsBody, NewsDate, NewsImage
     FROM news
     WHERE NewsID = ?"
);
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();

if (!$res->num_rows) {
    echo json_encode(['success'=>false,'message'=>'News not found']);
    exit;
}

$row = $res->fetch_assoc();
echo json_encode([
    'success'   => true,
    'NewsID'    => $id,
    'NewsTitle' => $row['NewsTitle'],
    'NewsBody'  => $row['NewsBody'],
    'NewsDate'  => $row['NewsDate'],         // raw timestamp
    'NewsImage' => 'data:image/jpeg;base64,' . base64_encode($row['NewsImage'])
]);
