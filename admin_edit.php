<?php
include 'Backend/db.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM menu WHERE id = $id");
$item = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Menu</title>
  <style>
    body { font-family: 'Poppins'; background: #fafafa; margin: 40px; }
    form { background: white; padding: 25px; border-radius: 10px; width: 400px; margin: auto; }
    input, textarea, select { width: 100%; margin: 10px 0; padding: 10px; border: 1px solid #ccc; border-radius: 6px; }
    button { background: #ff7b00; color: white; padding: 10px 15px; border: none; border-radius: 6px; cursor: pointer; }
    img { width: 100px; margin-bottom: 10px; border-radius: 8px; }
  </style>
</head>
<body>

<h2>Edit Menu</h2>

<form action="Backend/update_menu.php" method="POST" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $item['id']; ?>">

    <label>Nama Item</label>
    <input type="text" name="item_name" value="<?= $item['item_name']; ?>" required>

    <label>Deskripsi Singkat:</label>
    <input type="text" name="short_desc" value="<?= $item['short_desc']; ?>" maxlength="255" required>

    <label>Kategori</label>
    <select name="category" required>
      <option <?= $item['category']=='Makanan'?'selected':''; ?>>Makanan</option>
      <option <?= $item['category']=='Minuman'?'selected':''; ?>>Minuman</option>
    </select>

    <label>Harga</label>
    <input type="number" name="price" value="<?= $item['price']; ?>" required>

    <label>Stok</label>
    <input type="number" name="stock" value="<?= $item['stock']; ?>" required>

    <label>Gambar</label>
    <img src="<?= $item['image']; ?>" alt="">
    <input type="file" name="image">

    <label>Deskripsi (About)</label>
    <textarea name="about" rows="4"><?= $item['about']; ?></textarea>

    <button type="submit">Simpan Perubahan</button>
    <a href="admin.php">← Kembali</a>
</form>

</body>
</html>
