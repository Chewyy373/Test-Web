<?php
include 'db.php';

$q = $conn->query("
    SELECT 
        DATE(created_at) AS d, 
        SUM(total) AS revenue,
        COUNT(*) AS orders
    FROM orders
    GROUP BY DATE(created_at)
    ORDER BY d ASC
");

$labels = [];
$rev = [];
$ord = [];

while ($r = $q->fetch_assoc()) {
    $labels[] = $r['d'];
    $rev[] = (int)$r['revenue'];
    $ord[] = (int)$r['orders'];
}

echo json_encode([
    "labels" => $labels,
    "revenue" => $rev,
    "orders" => $ord
]);
