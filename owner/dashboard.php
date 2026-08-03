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

<link rel="stylesheet" href="../assets/owner.css?v=1">

</head>
<body>

<div class="sidebar">

<h2>🏨 STAYKU</h2>

<a href="dashboard.php"> Dashboard</a>

<a href="kamar.php"> Data Kamar</a>

<a href="booking.php"> Booking</a>

<a href="pembayaran.php"> Pembayaran</a>

<a href="../logout.php"> Logout</a>

</div>

<h1 style="color:red;"></h1>

<div class="content">

<div class="card welcome-card">

<h2>Selamat Datang, <?= $_SESSION['name']; ?> 👋</h2>

<p>Dashboard Owner StayKu</p>

<p class="tanggal">
📅 <?= date("d F Y"); ?>
</p>

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

<div class="card">

<h2>📋 Booking Terbaru</h2>

<table class="table">

<tr>
<th>Nama</th>
<th>Kamar</th>
<th>Check In</th>
<th>Status</th>
</tr>

<?php

$booking = $pdo->query("
SELECT users.fullname,
rooms.room_name,
bookings.check_in,
bookings.status
FROM bookings
JOIN users ON bookings.user_id=users.id
JOIN rooms ON bookings.room_id=rooms.id
ORDER BY bookings.id DESC
LIMIT 5
");

while($row=$booking->fetch()):
?>

<tr>

<td><?= $row['fullname']; ?></td>

<td><?= $row['room_name']; ?></td>

<td><?= $row['check_in']; ?></td>

<td>

<?php

if($row['status']=="Lunas"){

echo "<span class='status paid'>Lunas</span>";

}elseif($row['status']=="pending"){

echo "<span class='status pending'>Pending</span>";

}else{

echo "<span class='status cancel'>Batal</span>";

}

?>

</td>

</tr>

<?php endwhile; ?>

</table>

<div class="footer-admin">

© 2026 StayKu Mandalika | Owner Dashboard

</div>
</body>
</html>