<?php
include "db.php";

// Total revenue
$rev = $conn->query("SELECT SUM(total) AS total FROM orders WHERE status='Lunas'")->fetch_assoc()['total'] ?? 0;

// New customers
$new = $conn->query("SELECT COUNT(*) AS c FROM orders WHERE DATE(created_at) = CURDATE()")->fetch_assoc()['c'];

// Best selling product
$best = $conn->query("
  SELECT item_name, SUM(qty) AS total
  FROM order_items
  GROUP BY item_name
  ORDER BY total DESC
  LIMIT 1
")->fetch_assoc();

$bestProduct = $best ? $best['item_name'] : "Tidak ada";

// Average order value
$avg = $conn->query("SELECT AVG(total) AS avgv FROM orders")->fetch_assoc()['avgv'] ?? 0;

// Grafik revenue per hari
$revChart = $conn->query("
  SELECT DATE(created_at) AS tanggal, SUM(total) AS total 
  FROM orders 
  WHERE status='Lunas'
  GROUP BY DATE(created_at)
  ORDER BY tanggal ASC
");

$dataChart = [];
while ($row = $revChart->fetch_assoc()) {
  $dataChart[] = $row;
}

echo json_encode([
  "bestProduct" => $bestProduct,
  "totalRevenue" => $rev,
  "newCustomers" => $new,
  "avgOrderValue" => $avg,
  "chart" => $dataChart
]);
?>
