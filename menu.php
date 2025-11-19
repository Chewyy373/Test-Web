<?php
include 'Backend/db.php';
$result = $conn->query("SELECT * FROM menu");
$makanan = $conn->query("SELECT * FROM menu WHERE category='Makanan'");
$minuman = $conn->query("SELECT * FROM menu WHERE category='Minuman'");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Macau</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Css/style.css">
    <style>
        .hero{
        background-image: url('Image/Cover.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 85vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 60px 10%;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <header class="navbar">
        <div class="logo">
            <img src="Image/Logo.png" alt="Nutella Logo">
        </div>
        <nav>
            <ul class="menu" id="menu">
                <li><a href="#">Home</a></li>
                <li><a href="#menu-container">Menu</a></li>
                <li><a href="#">About</a></li>
            </ul>
        </nav>
        <div class="pesan">
            <a href="#"><img src="Image/CO.png"
            alt="Checkout"
            id="checkoutBtn"></a>
        </div>
    </header>
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <p class="small-text">SELAMAT PAGI</p>
            <h1>Awali hari dengan <br><span>Lorem Ipsum</span></h1>
            <a href="#" class="btn" alt="Checkout" id="checkoutBtn">Order Now</a>
        </div>
    </section>
    <section class="food-section" id="menu-container">
        <div class="food-container">
            <p class="food-subtitle">🍽️ Our Menu</p>
            <h2 class="food-title">Makanan</h2>
        <div class="food-list">
            <?php while($row = $makanan->fetch_assoc()) { ?>
            <div class="food-card"
                data-name="<?= htmlspecialchars($row['item_name']) ?>"
                data-price="<?= htmlspecialchars($row['price']) ?>">
                <img src="<?= htmlspecialchars($row['image']) ?>"
                 alt="<?= htmlspecialchars($row['item_name']) ?>" />
                <h3><?= htmlspecialchars($row['item_name']) ?></h3>
                <p class="desc"><?= htmlspecialchars($row['short_desc']) ?></p>
                  <button class="price-btn"
                          data-id="<?= $row['id'] ?>"
                          data-name="<?= htmlspecialchars($row['item_name']) ?>"
                          data-price="<?= $row['price'] ?>">
                    Rp.<?= number_format($row['price'], 0, ',', '.') ?>
                <button class="about-btn" onclick="window.location.href='about.php?id=<?= $row['id'] ?>'">About</button>
            </div>
            <?php } ?>
        <div class="food-container">
            <h2 class="food-title">Minuman</h2>
        <div class="food-list">
            <?php while($row = $minuman->fetch_assoc()) { ?>
            <div class="food-card"
                data-name="<?= htmlspecialchars($row['item_name']) ?>"
                data-price="<?= htmlspecialchars($row['price']) ?>">
                <img src="<?= htmlspecialchars($row['image']) ?>"
                 alt="<?= htmlspecialchars($row['item_name']) ?>" />
                <h3><?= htmlspecialchars($row['item_name']) ?></h3>
                <h3 class="desc"><?= htmlspecialchars($row['short_desc']) ?></h3>
                  <button class="price-btn"
                          data-id="<?= $row['id'] ?>"
                          data-name="<?= htmlspecialchars($row['item_name']) ?>"
                          data-price="<?= $row['price'] ?>">
                    Rp.<?= number_format($row['price'], 0, ',', '.') ?>
                <button class="about-btn" onclick="window.location.href='about.php?id=<?= $row['id'] ?>'">About</button>
            </div>
            <?php } ?>
        </div>
    </section>
    <!-- Footer Section -->
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
    <script src="Js/main.js"></script>
</body>
</html>
