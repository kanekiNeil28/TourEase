<?php
require_once __DIR__ . '/../db_connect.php';

$month = $_GET['month'] ?? date('m');
$year = $_GET['year'] ?? date('Y');

$sql = "SELECT SUM(GuestCountUndiscounted + GuestCountDiscounted) AS total 
        FROM transaction 
        WHERE MONTH(TransactionDate) = $month 
          AND YEAR(TransactionDate) = $year
          AND Foreigner = 1";

$result = $conn->query($sql);
$row = $result->fetch_assoc();
echo $row['total'] ?? 0;
?>
