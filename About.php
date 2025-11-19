<?php
include 'Backend/db.php';

if (!isset($_GET['id'])) {
    echo "Item tidak ditemukan.";
    exit;
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM menu WHERE id = $id");

if ($result->num_rows == 0) {
    echo "Data tidak ditemukan.";
    exit;
}

$item = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $item['item_name']; ?> - Detail</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Macau</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Css/About.css">
</head>
<body>
    <header class="navbar">
        <div class="logo">
            <img src="Image/Logo.png" alt="Nutella Logo">
        </div>
        <nav>
            <ul class="menu" id="menu">
                <li><a href="menu.php">Home</a></li>
                <li><a href="#menu-container">Menu</a></li>
                <li><a href="#">About</a></li>
            </ul>
        </nav>
        <div class="pesan">
            <a href="#"><img src="Image/CO.png" alt="Checkout"></a>
        </div>
    </header>
    <header class="hero">
    <h1>Soes Kering dengan <span class="highlight">Macau</span></h1>
  </header>
  <section class="gambar-utama">
    <img src="<?= $item['image']; ?>" alt="<?= $item['item_name']; ?>" class="about-image">
  </section>

  <!-- Bahan-bahan -->
  <section class="bahan">
    <h2><?= $item['item_name']; ?></h2>
    <p class="sub">Harga: Rp<?= number_format($item['price'], 0, ',', '.'); ?></p>
    <ul>
        <li class="desc"><?= nl2br($item['about']); ?></li>
    </ul>
    <a href="menu.php" class="download">Kembali</a>
  </section>
      <footer class="footer">
  <div class="footer-container">
    <!-- About Us -->
    <div class="footer-section about">
      <h3>ABOUT US</h3>
      <div class="footer-line"></div>
      <p>
        The Love Boat soon will be making another run. The Love Boat prompt misses something for everyone. 
        Our Speed Racer. Going Speed Racer to best.
      </p>
      <div class="socials">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><img src="Image/Insta.png" alt="Instagram"></a>
        <a href="#"><img src="Image/Wa.png" alt="Whatsapp"></i></a>
      </div>
    </div>

    <!-- Quick Links -->
    <div class="footer-section links">
      <h3>QUICK LINKS</h3>
      <div class="footer-line"></div>
      <ul>
        <li><a href="#">HOME</a></li>
        <li><a href="#">MENU</a></li>
        <li><a href="#">ABOUT</a></li>
        <li><a href="#">BLOG</a></li>
        <li><a href="#">CONTACT</a></li>
      </ul>
    </div>

    <!-- Working Time -->
    <div class="footer-section time">
      <h3>WORKING TIME</h3>
      <div class="footer-line"></div>
      <ul>
        <li>Monday - Tuesday ------ 09.00 - 22.00</li>
        <li>Wednesday ------ 08.30 - 20.30</li>
        <li>Thursday - Friday ------ 09.45 - 19.55</li>
        <li>Saturday ------ 10.00 - 20.45</li>
        <li>Sunday ------ 08.00 - 19.10</li>
        <li>Public Holidays ------ Closed</li>
      </ul>
    </div>

    <!-- Menu Categories -->
    <div class="footer-section categories">
      <h3>MENU CATEGORIES</h3>
      <div class="footer-line"></div>
      <ul>
        <li><a href="#">APPETIZERS</a></li>
        <li><a href="#">BREAKFAST</a></li>
        <li><a href="#">LUNCH</a></li>
        <li><a href="#">DINNER</a></li>
        <li><a href="#">MEAT & FISH</a></li>
        <li><a href="#">SOUPS</a></li>
      </ul>
    </div>
  </div>

  <div class="footer-bottom">
    <p>© Copyrights 2016 - All Rights Reserved</p>
  </div>
</footer>
</body>
</html>
