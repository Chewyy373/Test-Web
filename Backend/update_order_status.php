<?php
header('Content-Type: application/json');
include 'db.php';

// Ambil data dari request JSON
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id']) || !isset($data['action'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}

$orderId = $data['id']; // KODE, bukan ID
$action = $data['action'];

// Ambil data order berdasarkan KODE
$orderQuery = $conn->prepare("SELECT items, status FROM orders WHERE kode = ?");
$orderQuery->bind_param("s", $orderId);
$orderQuery->execute();
$orderResult = $orderQuery->get_result();

if ($orderResult->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Order not found']);
    exit;
}

$order = $orderResult->fetch_assoc();
$items = json_decode($order['items'], true);

// Jika Sudah Bayar
if ($action === 'paid') {
    $newStatus = 'Lunas';
    $update = $conn->prepare("UPDATE orders SET status = ? WHERE kode = ?");
    $update->bind_param("ss", $newStatus, $orderId);
    $update->execute();

    echo json_encode([
        'status' => 'success',
        'new_status' => $newStatus
    ]);
    exit;
}

// Jika Batalkan
if ($action === 'cancel') {
    $newStatus = 'Dibatalkan';

    // Kembalikan stok
    $updatedStocks = [];
    if (is_array($items)) {
        foreach ($items as $item) {
            $id = intval($item['id']);
            $qty = intval($item['qty']);

            $stokResult = $conn->query("SELECT stock, item_name FROM menu WHERE id = $id");
            if ($stokResult->num_rows > 0) {
                $stokRow = $stokResult->fetch_assoc();
                $newStock = $stokRow['stock'] + $qty;

                $conn->query("UPDATE menu SET stock = $newStock WHERE id = $id");

                $updatedStocks[] = [
                    'id' => $id,
                    'name' => $stokRow['item_name'],
                    'new_stock' => $newStock
                ];
            }
        }
    }

    // Update status pesanan
    $update = $conn->prepare("UPDATE orders SET status = ? WHERE kode = ?");
    $update->bind_param("ss", $newStatus, $orderId);
    $update->execute();

    echo json_encode([
        'status' => 'success',
        'new_status' => $newStatus,
        'updatedStocks' => $updatedStocks
    ]);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
?>
