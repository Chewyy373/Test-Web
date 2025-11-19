<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];
    $name = $_POST['item_name'];
    $short_desc = $_POST['short_desc'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $about = $_POST['about'];

    // Jika upload gambar baru
    if (!empty($_FILES['image']['name'])) {
        $image_path = "../upload/" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);

        $conn->query("UPDATE menu SET image='$image_path' WHERE id=$id");
    }

    // Update data lainnya
    $conn->query("
        UPDATE menu SET 
        item_name='$name',
        short_desc='$short_desc',
        category='$category',
        price='$price',
        stock='$stock',
        about='$about'
        WHERE id=$id
    ");

    header("Location: ../admin.php");
    exit;
}
?>
