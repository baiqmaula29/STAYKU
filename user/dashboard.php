<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard User</title>

<link rel="stylesheet" href="../assets/user.css">

</head>

<body>

<div class="navbar">

    <div class="logo">
        🏨 StayKu Mandalika
    </div>

    <ul class="nav-menu">

        <li><a href="dashboard.php">🏠 Home</a></li>

        <li><a href="kamar.php">🛏️ Kamar</a></li>

        <li><a href="riwayat.php">📋 Riwayat</a></li>

        <li><a href="profile.php">👤 Profil</a></li>

        <li><a href="../logout.php" class="logout">🚪 Logout</a></li>

    </ul>

</div>
<!-- HERO -->

<section class="hero">

<div class="hero-left">

<h1>🏍️ Stayku Mandalika</h1>

<p>
Nikmati pengalaman menginap yang nyaman dekat
Pertamina Mandalika International Circuit,
Pantai Kuta Mandalika, Bukit Merese dan
berbagai destinasi wisata terbaik di Lombok.
</p>

<a href="kamar.php" class="btn">
🛏️ Booking Sekarang
</a>

<div class="hero-right">
    <img
        id="slider"
        src="../assets/upload/slide1.jpg"
        style="width:100%; max-width:500px; height:320px; object-fit:cover; border-radius:20px;">
</div>

</section>

<!-- KEUNGGULAN -->

<div class="container">

<h2 class="section-title">
Kenapa Memilih Stayku Mandalika?
</h2>

<div class="feature">

<div class="feature-box">

<h2>🏍️</h2>

<h3>Dekat Sirkuit</h3>

<p>
Lokasi strategis dekat Pertamina Mandalika International Circuit.
</p>

</div>

<div class="feature-box">

<h2>🌊</h2>

<h3>Dekat Pantai</h3>

<p>
Dekat Pantai Kuta Mandalika dan Tanjung Aan.
</p>

</div>

<div class="feature-box">

<h2>🛏️</h2>

<h3>Kamar Nyaman</h3>

<p>
Pilihan kamar harian dan mingguan yang bersih dan nyaman.
</p>

</div>

<div class="feature-box">

<h2>💰</h2>

<h3>Harga Terjangkau</h3>

<p>
Pilihan harga yang sesuai untuk wisatawan.
</p>

</div>

</div>

</div>

<!-- DESTINASI -->

<div class="container">

<h2 class="section-title">
📍 Destinasi Wisata Sekitar
</h2>

<div class="feature">

<div class="feature-box">

<h2>🏍️</h2>

<h3>Mandalika Circuit</h3>

<p>
Sirkuit internasional penyelenggara MotoGP Indonesia.
</p>

</div>

<div class="feature-box">

<h2>🌊</h2>

<h3>Pantai Kuta</h3>

<p>
Pantai pasir putih yang menjadi ikon Mandalika.
</p>

</div>

<div class="feature-box">

<h2>🌅</h2>

<h3>Bukit Merese</h3>

<p>
Spot favorit menikmati pemandangan dan matahari terbenam.
</p>

</div>

<div class="feature-box">

<h2>🏖️</h2>

<h3>Pantai Tanjung Aan</h3>

<p>
Pantai indah dengan pasir putih dan air laut jernih.
</p>

</div>

</div>

</div>

<footer class="footer">

<h2>🏨 StayKu Mandalika</h2>

<p>
Penginapan nyaman dekat Pertamina Mandalika International Circuit.
</p>

<p>
Kabupaten Lombok Tengah • Nusa Tenggara Barat
</p>

<hr>

<p>

📧 staykumandalika@gmail.com

|

📞 0812-3456-7890

</p>

<p>

© 2025 StayKu Mandalika

</p>

</footer>

<script>
const gambar = [
    "../assets/upload/slide1.jpg",
    "../assets/upload/slide2.jpg",
    "../assets/upload/slide3.jpg",
    "../assets/upload/slide4.jpg"
];

let index = 0;

setInterval(() => {
    index = (index + 1) % gambar.length;
    document.getElementById("slider").src = gambar[index];
}, 3000);
</script>

</body>

</html>