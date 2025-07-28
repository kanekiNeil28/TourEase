<?php
require_once __DIR__ . '/../db_connect.php';

$month = isset($_GET['month']) ? (int)$_GET['month'] : 0;
$year = isset($_GET['year']) ? (int)$_GET['year'] : 0;

$sql = "SELECT SUM(TotalFee) AS total_fees FROM transaction WHERE 1";

if ($month > 0) {
    $sql .= " AND MONTH(TransactionDate) = $month";
}
if ($year > 0) {
    $sql .= " AND YEAR(TransactionDate) = $year";
}

$result = $conn->query($sql);
$row = $result->fetch_assoc();
echo $row['total_fees'] ?? 0;
?>
