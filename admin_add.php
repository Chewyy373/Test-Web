<?php
include 'Backend/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['item_name'];
  $short_desc = $_POST['short_desc'];
  $category = $_POST['category'];
  $price = $_POST['price'];
  $stock = $_POST['stock'];
  $about = $_POST['about'];

  // Upload gambar
  $image_path = "upload/" . basename($_FILES['image']['name']);
  move_uploaded_file($_FILES['image']['tmp_name'], $image_path);

  $sql = "INSERT INTO menu (item_name, short_desc, category, price, image, stock, about)
          VALUES ('$name', '$short_desc', '$category', '$price', '$image_path', '$stock', '$about')";
  if ($conn->query($sql)) {
    header("Location: admin.php");
    exit;
  } else {
    echo "Gagal menyimpan data.";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Menu</title>
  <style>
    body { font-family: 'Poppins'; background: #fafafa; margin: 40px; }
    form { background: white; padding: 25px; border-radius: 10px; width: 400px; margin: auto; }
    input, textarea, select { width: 100%; margin: 10px 0; padding: 10px; border: 1px solid #ccc; border-radius: 6px; }
    button { background: #ff7b00; color: white; padding: 10px 15px; border: none; border-radius: 6px; cursor: pointer; }
    a { text-decoration: none; color: #555; }
  </style>
</head>
<body>
  <h2>Tambah Menu Baru</h2>
  <form action="" method="POST" enctype="multipart/form-data">
    <label>Nama Item</label>
    <input type="text" name="item_name" required>

    <label>Deskripsi Singkat:</label>
    <input type="text" name="short_desc" maxlength="255" required><br>

    <label>Kategori</label>
    <select name="category" required>
      <option value="Makanan">Makanan</option>
      <option value="Minuman">Minuman</option>
    </select>

    <label>Harga</label>
    <input type="number" name="price" required>

    <label>Stok</label>
    <input type="number" name="stock" required>

    <label>Gambar</label>
    <input type="file" name="image" required>

    <label>Deskripsi (About)</label>
    <textarea name="about" rows="4" placeholder="Tulis deskripsi detail..."></textarea>

    <button type="submit">Simpan</button>
    <a href="admin.php">← Kembali</a>
  </form>
</body>
</html>
