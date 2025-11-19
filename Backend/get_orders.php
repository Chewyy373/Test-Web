<?php
include 'db.php';
header('Content-Type: application/json');

$result = $conn->query("SELECT * FROM orders ORDER BY id DESC");
$orders = [];

while ($row = $result->fetch_assoc()) {
  $items = [];
  $resItems = $conn->query("SELECT item_name, qty, price FROM order_items WHERE order_id = ".$row['id']);
  while ($i = $resItems->fetch_assoc()) {
    $items[] = $i;
  }
  $row['items'] = $items;
  $orders[] = $row;
}

echo json_encode($orders);
?>
