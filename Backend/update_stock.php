<?php
header('Content-Type: application/json');
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents("php://input"), true);

  if (!$data) {
    echo json_encode(["status" => "error", "message" => "Data kosong"]);
    exit;
  }

  foreach ($data as $item) {
    $id = intval($item['id']);
    $qty = intval($item['qty']);

    $update = $conn->query("UPDATE menu SET stock = stock - $qty WHERE id = $id AND stock >= $qty");

    if (!$update || $conn->affected_rows == 0) {
      echo json_encode(["status" => "error", "message" => "Stok tidak cukup untuk ID $id"]);
      exit;
    }
  }

  echo json_encode(["status" => "success"]);
}
$conn->close();
?>
