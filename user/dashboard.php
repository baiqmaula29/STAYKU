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
        🏨 HostelKu
    </div>

    <ul class="nav-menu">

        <li>
            <a href="dashboard.php">🏠 Home</a>
        </li>

        <li>
            <a href="kamar.php">🛏️ Kamar</a>
        </li>

        <li>
            <a href="riwayat.php">📋 Riwayat</a>
        </li>

        <li>
            <a href="profile.php">👤 Profil</a>
        </li>

        <li>
            <a href="../logout.php" class="logout">
                🚪 Logout
            </a>
        </li>

    </ul>

</div>
<!-- HERO -->

<section class="hero">

<h1>
🏨 HostelKu
</h1>

<p>
Temukan kamar hostel nyaman dengan harga terbaik.
Booking lebih cepat, mudah dan aman.
</p>

<a href="kamar.php" class="btn">
Cari Kamar
</a>

</section>

<!-- FITUR -->

<div class="feature">

<div class="feature-box">
<h2>🛏️</h2>
<h3>Kamar Nyaman</h3>
<p>Bersih, rapi dan lengkap.</p>
</div>

<div class="feature-box">
<h2>💰</h2>
<h3>Harga Murah</h3>
<p>Harian dan mingguan.</p>
</div>

<div class="feature-box">
<h2>📍</h2>
<h3>Lokasi Strategis</h3>
<p>Dekat kampus dan pusat kota.</p>
</div>

</div>

        </div>

    </div>

</div>

<footer class="footer">

<div class="footer-content">

<h2>🏨 HostelKu</h2>

<p>
Hostel nyaman dengan harga terbaik untuk mahasiswa dan wisatawan.
</p>

<hr>

<p>

© 2025 HostelKu

|

Email :
hostelku@gmail.com

|

Telp :
0812-3456-7890

</p>

</div>

</footer>

</body>
</html>