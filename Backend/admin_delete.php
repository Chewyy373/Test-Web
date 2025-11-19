<?php
include 'Backend/db.php';

$id = $_GET['id'];
$conn->query("DELETE FROM menu WHERE id = $id");
header("Location: admin.php");
exit;
?>
