<?php
include 'db.php';
header('Content-Type: application/json');

// Pastikan hanya menerima request POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(["status" => "error", "message" => "Metode tidak diizinkan"]);
  exit;
}

// Ambil data dari body JSON
$data = json_decode(file_get_contents("php://input"), true);

// Validasi input dasar
if (!$data || !isset($data['items']) || empty($data['items'])) {
  echo json_encode(["status" => "error", "message" => "Data pesanan tidak valid"]);
  exit;
}

// Ambil data umum
$kode = $conn->real_escape_string($data['kode'] ?? ('ORD' . rand(10000, 99999)));
$customer_name = $conn->real_escape_string($data['customer_name'] ?? 'Pelanggan Baru');
$alamat = $conn->real_escape_string($data['alamat'] ?? '-');
$total_price = floatval($data['total_price'] ?? 0);
$status = $conn->real_escape_string($data['status'] ?? 'pending');

// 🔹 Simpan ke tabel `orders`
$sql = "INSERT INTO orders (kode, customer_name, alamat, total_price, status, created_at)
        VALUES ('$kode', '$customer_name', '$alamat', '$total_price', '$status', NOW())";

if (!$conn->query($sql)) {
  echo json_encode(["status" => "error", "message" => "Gagal menyimpan pesanan: " . $conn->error]);
  exit;
}

$order_id = $conn->insert_id;

// 🔹 Simpan item ke tabel `order_items` dan kurangi stok
$item_stmt = $conn->prepare("
  INSERT INTO order_items (order_id, item_id, item_name, qty, price)
  VALUES (?, ?, ?, ?, ?)
");

foreach ($data['items'] as $item) {
  $id = intval($item['id']);
  $name = $conn->real_escape_string($item['name']);
  $qty = intval($item['qty']);
  $price = floatval($item['price']);

  // Simpan detail item
  $item_stmt->bind_param("iisid", $order_id, $id, $name, $qty, $price);
  $item_stmt->execute();

  // Kurangi stok di tabel menu
  $conn->query("UPDATE menu SET stock = stock - $qty WHERE id = $id");
}

$item_stmt->close();
$conn->close();

echo json_encode(["status" => "success", "message" => "Pesanan berhasil disimpan"]);
?>
