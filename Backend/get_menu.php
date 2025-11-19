<?php
header("Content-Type: application/json");
include "db.php";

$sql = "SELECT * FROM menu";
$result = $conn->query($sql);

$menu = [];
while ($row = $result->fetch_assoc()) {
    $menu[] = $row;
}

echo json_encode($menu);
?>
