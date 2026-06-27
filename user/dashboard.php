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

<div class="hero">

    <h1>
        Selamat Datang,
        <?= $_SESSION['name']; ?> 👋
    </h1>

    <p>
        Temukan kamar hostel terbaik dengan harga terjangkau.
    </p>

    <br>

    <a href="kamar.php" class="btn">
        Booking Sekarang
    </a>

</div>

<!-- FITUR -->

<div class="container">

    <div class="feature">

        <div class="feature-box">

            <h3>🏨 Kamar Nyaman</h3>

            <p>
                Kamar bersih dan nyaman untuk istirahat.
            </p>

        </div>

        <div class="feature-box">

            <h3>💰 Harga Terjangkau</h3>

            <p>
                Harga sesuai kantong mahasiswa dan traveler.
            </p>

        </div>

        <div class="feature-box">

            <h3>🔒 Aman</h3>

            <p>
                Data booking tersimpan dengan aman.
            </p>

        </div>

    </div>

</div>

</body>
</html>