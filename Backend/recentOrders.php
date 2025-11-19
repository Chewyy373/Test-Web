<?php
include 'db.php';

$res = $conn->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 5");

$list = [];
while($row = $res->fetch_assoc()) {
    $list[] = $row;
}

echo json_encode($list);
