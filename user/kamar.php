<?php

session_start();
require '../config.php';

$data = $pdo->query("
SELECT *
FROM rooms
WHERE status='available'
");

?>

<!DOCTYPE html>
<html>
<head>

<title>Kamar</title>

<link rel="stylesheet"
href="../assets/user.css">

</head>
<body>

<div class="navbar">

<div class="logo">HOSTELKU</div>

<div class="menu">

<a href="dashboard.php">Home</a>
<a href="kamar.php">Kamar</a>
<a href="riwayat.php">Riwayat</a>
<a href="profile.php">Profil</a>

</div>

</div>

<div class="container">

<h2 class="section-title">
Daftar Kamar
</h2>

<div class="room-grid">

<?php while($room = $data->fetch()): ?>

<div class="room-card">

<img
src="../assets/upload/<?= $room['photo']; ?>">

<div class="room-body">

<h3>
<?= $room['room_name']; ?>
</h3>

<p>
No. <?= $room['room_number']; ?>
</p>

<p class="price">
Rp <?= number_format($room['price']); ?>
</p>

<a
class="btn"
href="boking.php?room_id=<?= $room['id']; ?>">

Booking Sekarang

</a>

</div>

</div>

<?php endwhile; ?>

</div>

</div>

</body>
</html>