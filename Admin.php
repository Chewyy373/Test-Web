<?php
include 'Backend/db.php';

// Ambil data menu dan pesanan
$menus = $conn->query("SELECT * FROM menu ORDER BY id DESC");
$orders = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <link rel="stylesheet" href="Css/Admin.css">
  <script src="Js/Admin.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="close-btn" onclick="toggleSidebar()">✖</div>
    <h2>Admin Panel</h2>
    <button class="tab-btn active" data-target="dashboard-panel">📊 Dashboard</button>
    <button class="tab-btn" data-target="menu-panel">🍔 Daftar Menu</button>
    <button class="tab-btn" data-target="order-panel">📦 Daftar Pesanan</button>
  </div>

  <!-- Konten -->
  <div class="content">
    <div class="hamburger" onclick="toggleSidebar()">
      ☰
    </div>
        <!-- ============ DASHBOARD PANEL ============ -->
<!-- ============ DASHBOARD PANEL ============ -->
<div id="dashboard-panel" class="panel">

  <div class="top-bar">
    <h2>📊 Dashboard</h2>
  </div>

  <!-- SUMMARY CARDS -->
  <div class="grid">
    <div class="card">
      <div class="stat-value" id="rev"></div>
      <div class="stat-label">Total Revenue</div>
    </div>

    <div class="card">
      <div class="stat-value" id="cust"></div>
      <div class="stat-label">Total Customers</div>
    </div>

    <div class="card">
      <div class="stat-value" id="orders"></div>
      <div class="stat-label">Total Orders</div>
    </div>

    <div class="card">
      <div class="stat-value" id="conv"></div>
      <div class="stat-label">Conversion Rate</div>
    </div>
  </div>

  <!-- BEST SELLING PRODUCTS -->
  <div class="card">
    <div class="section-title">Most Selling Products</div>
    <div id="bestProducts"></div>
  </div>

  <!-- SUMMARY CHART -->
  <div class="card">
    <div class="section-title">Summary Chart</div>
    <select id="chartType">
      <option value="both">Revenue + Orders</option>
      <option value="revenue">Revenue Only</option>
      <option value="order">Orders Only</option>
    </select>

    <div class="chart-wrapper" style="margin-top:15px;">
      <canvas id="summaryChart"></canvas>
    </div>
  </div>

</div>

    <!-- END DASHBOARD -->
    <div id="menu-panel" class="panel hidden">
      <div class="top-bar">
        <h2>🍔 Daftar Menu</h2>
        <a href="admin_add.php" class="btn">+ Tambah Menu</a>
      </div>
    <div class="table-container">
      <table>
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Kategori</th>
          <th>Harga</th>
          <th>Stok</th>
          <th>Gambar</th>
          <th>Tindakan</th>
        </tr>
        <?php while ($row = $menus->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id']; ?></td>
          <td><?= htmlspecialchars($row['item_name']); ?></td>
          <td><?= htmlspecialchars($row['category']); ?></td>
          <td>Rp<?= number_format($row['price'], 0, ',', '.'); ?></td>
          <td><?= $row['stock']; ?></td>
          <td><img src="<?= htmlspecialchars($row['image']); ?>" width="60"></td>
          <td>
            <a href="admin_edit.php?id=<?= $row['id']; ?>" class="btn">Edit</a>
            <a href="admin_delete.php?id=<?= $row['id']; ?>" class="btn" style="background:red;">Hapus</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </table>
    </div>
    </div>
    <!-- Panel Pesanan -->
    <div id="order-panel" class="panel hidden">
      <h2>📦 Daftar Pesanan</h2>
      <table id="orderTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Pelanggan</th>
            <th>Items</th>
            <th>Total</th>
            <th>Waktu</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = $orders->fetch_assoc()) { ?>
            <tr data-id="<?= htmlspecialchars($row['kode']) ?>">
              <td><?= $row['kode'] ?></td>
              <td><?= htmlspecialchars($row['customer_name']) ?></td>
              <td>
                <?php
                $items = json_decode($row['items'], true);
                if ($items && is_array($items)) {
                    foreach ($items as $i) {
                        echo htmlspecialchars($i['name']) . " x" . htmlspecialchars($i['qty']) . "<br>";
                    }
                } else {
                    echo "-";
                }
                ?>
              </td>
              <td>Rp<?= number_format($row['total'], 0, ',', '.') ?></td>
              <td><?= date("d M Y H:i", strtotime($row['created_at'])) ?></td>
              <td>
                <?php if ($row['status'] === 'Pending'): ?>
                  <button class="btn-paid">Sudah Bayar</button>
                  <button class="btn-cancel">Batalkan</button>
                <?php elseif ($row['status'] === 'Lunas'): ?>
                  <span style="color:green;font-weight:bold;">Lunas</span>
                <?php elseif ($row['status'] === 'Dibatalkan'): ?>
                  <span style="color:red;font-weight:bold;">Dibatalkan</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <script>
function toggleSidebar() {
  document.querySelector(".sidebar").classList.toggle("active");
}
  // Switch panel
  document.querySelectorAll(".tab-btn").forEach(btn => {
    btn.onclick = () => {
      document.querySelectorAll(".tab-btn").forEach(b => b.classList.remove("active"));
      document.querySelectorAll(".panel").forEach(p => p.classList.add("hidden"));

      btn.classList.add("active");
      document.getElementById(btn.dataset.target).classList.remove("hidden");
    };
  });
</script>
</body>
</html>
