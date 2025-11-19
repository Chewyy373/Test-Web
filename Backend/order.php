<?php
header("Content-Type: application/json");
include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["items"]) || count($data["items"]) == 0) {
    echo json_encode(["status" => "error", "message" => "No items provided"]);
    exit;
}

// Simpan order utama
$conn->query("INSERT INTO orders () VALUES ()");
$order_id = $conn->insert_id;

// Simpan item pesanan
foreach ($data["items"] as $item) {
    $menu_id = intval($item["menu_id"]);
    $quantity = intval($item["quantity"]);

    // Cek stok
    $check = $conn->query("SELECT stock FROM menu WHERE id=$menu_id")->fetch_assoc();
    if ($check["stock"] < $quantity) {
        echo json_encode(["status" => "error", "message" => "Stok tidak cukup untuk item ID $menu_id"]);
        exit;
    }

    // Kurangi stok
    $conn->query("UPDATE menu SET stock = stock - $quantity WHERE id=$menu_id");

    // Simpan item order
    $conn->query("INSERT INTO order_items (order_id, menu_id, quantity) VALUES ($order_id, $menu_id, $quantity)");
}

echo json_encode(["status" => "success", "message" => "Pesanan berhasil disimpan", "order_id" => $order_id]);
?>
