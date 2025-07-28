<?php
require_once __DIR__ . '/../db_connect.php';
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

$sql = "SELECT SUM(GuestCountUndiscounted + GuestCountDiscounted) AS total
        FROM transaction WHERE YEAR(TransactionDate) = $year";

$result = $conn->query($sql);
$row = $result->fetch_assoc();
echo $row['total'] ?? 0;
?>
