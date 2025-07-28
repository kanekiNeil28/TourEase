<?php
require_once __DIR__ . '/../db_connect.php';

$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

$data = array_fill(1, 12, 0); // default 0s for all 12 months

$sql = "SELECT MONTH(TransactionDate) AS month,
               SUM(GuestCountUndiscounted + GuestCountDiscounted) AS total
        FROM transaction
        WHERE YEAR(TransactionDate) = $year
        GROUP BY MONTH(TransactionDate)";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $data[(int)$row['month']] = (int)$row['total'];
}

echo json_encode(array_values($data)); // just the values, [0, 12, 45, ...]
?>
