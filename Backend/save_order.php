<?php
include 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
  echo json_encode(['status' => 'error', 'message' => 'No data received']);
  exit;
}

$kode = "ORD" . rand(10000, 99999);
$customer_name = $data['customer_name'] ?? '';
$alamat = $data['alamat'] ?? '';
$items = json_encode($data['items'] ?? []);
$total = $data['total_price'] ?? 0;
$status = 'Pending';

$stmt = $conn->prepare("INSERT INTO orders (kode, customer_name, alamat, items, total, status) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssds", $kode, $customer_name, $alamat, $items, $total, $status);

if ($stmt->execute()) {
  echo json_encode(['status' => 'success']);
} else {
  echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}
?>
