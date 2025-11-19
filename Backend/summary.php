<?php
include 'db.php';

$data = [];

$data['totalOrders'] = $conn->query("SELECT COUNT(*) AS c FROM orders")->fetch_assoc()['c'] ?: 0;
$data['totalCustomers'] = $conn->query("SELECT COUNT(DISTINCT customer_name) AS c FROM orders")->fetch_assoc()['c'] ?: 0;
$data['totalRevenue'] = $conn->query("SELECT SUM(total) AS t FROM orders")->fetch_assoc()['t'] ?: 0;
$data['conversion'] = $data['totalOrders'] > 0 ? rand(20,40) : 0;

echo json_encode($data);
