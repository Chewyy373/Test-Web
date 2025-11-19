<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Checkout</title>
  <link rel="stylesheet" href="Css/Checkout.css">
</head>
<body>

<div class="checkout-container">
  <h2>Checkout Pesanan Anda</h2>

  <div class="user-info">
    <label for="nama">Nama Lengkap</label>
    <input type="text" id="nama" placeholder="Masukkan nama anda">

    <label for="alamat">Alamat Lengkap</label>
    <textarea id="alamat" rows="3" placeholder="Masukkan alamat pengiriman"></textarea>
  </div>

  <table id="checkoutTable">
    <thead>
      <tr>
        <th>Nama Item</th>
        <th>Harga Satuan</th>
        <th>Jumlah</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>

  <p class="total" id="totalHarga">Total: Rp 0</p>
  <button id="bayarWA" class="whatsapp-btn">Pembayaran melalui WhatsApp</button>
  <a href="menu.php" class="back-btn">Kembali</a>
</div>

<script src="Js/Checkout.js"></script>
</body>
</html>
