<?php
session_start();
require '../config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}

// Statistik
$totalKamar = $pdo->query("SELECT COUNT(*) FROM rooms")->fetchColumn();

$totalBooking = $pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();

$totalUser = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

$totalPendapatan = $pdo->query("
SELECT IFNULL(SUM(total_price),0)
FROM bookings
WHERE status='Lunas'
")->fetchColumn();
?>

<!DOCTYPE html>
<html>
<head>

<title>Dashboard Owner</title>

<link rel="stylesheet" href="../assets/style.css?v=999">

</head>
<body>

<div class="sidebar">

<h2>HOSTEL</h2>

<a href="dashboard.php">Dashboard</a>

<a href="kamar.php">Data Kamar</a>

<a href="boking.php">Booking</a>

<a href="pembayaran.php">Pembayaran</a>

<a href="../logout.php">Logout</a>

</div>

<h1 style="color:red;">TES DASHBOARD BARU</h1>

<div class="content">

    <div class="card">

        <h2>
            Selamat Datang, <?= $_SESSION['name']; ?>
        </h2>

        <p>Dashboard Owner Hostel</p>

    </div>

    <div class="dashboard-grid">

        <div class="card-box">
            <h3>🛏️ Total Kamar</h3>
            <h1><?= $totalKamar; ?></h1>
        </div>

        <div class="card-box">
            <h3>📋 Total Booking</h3>
            <h1><?= $totalBooking; ?></h1>
        </div>

        <div class="card-box">
            <h3>👤 Total User</h3>
            <h1><?= $totalUser; ?></h1>
        </div>

        <div class="card-box">
            <h3>💰 Pendapatan</h3>
            <h1>Rp <?= number_format($totalPendapatan); ?></h1>
        </div>

    </div>

</div>

</body>
</html>