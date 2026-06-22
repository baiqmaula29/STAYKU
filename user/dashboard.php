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

<title>Dashboard User</title>

<link rel="stylesheet"
href="../assets/user.css">

</head>
<body>

<div class="navbar">

<div class="logo">
HOSTELKU
</div>

<div class="menu">

<a href="dashboard.php">Home</a>

<a href="kamar.php">Kamar</a>

<a href="riwayat.php">Riwayat</a>

<a href="profile.php">Profil</a>

<a href="../logout.php">Logout</a>

</div>

</div>

<div class="hero">

<div class="hero-text">

<h1>
Selamat Datang,
<?= $_SESSION['name']; ?> 👋
</h1>

<p>
Cari dan booking kamar hostel favoritmu
</p>

<a href="kamar.php" class="btn">
Lihat Kamar
</a>

</div>

<div class="hero-image">

<img
src="https://images.unsplash.com/photo-1566073771259-6a8506099945">

</div>

</div>

<div class="container">

<h2 class="section-title">
Kamar Tersedia
</h2>

<div class="feature">

<div class="feature-box">
🏨
<h3>Harga Terbaik</h3>
<p>Dapatkan harga terbaik setiap hari</p>
</div>

<div class="feature-box">
🛡️
<h3>Aman & Nyaman</h3>
<p>Kamar bersih dan fasilitas lengkap</p>
</div>

<div class="feature-box">
💳
<h3>Pembayaran Mudah</h3>
<p>Transfer atau E-Wallet</p>
</div>

</div>

</div>

</body>
</html>