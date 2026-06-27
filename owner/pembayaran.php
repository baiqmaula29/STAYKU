<?php

session_start();
require '../config.php';

$query = $pdo->query("
SELECT
payments.*,
users.fullname,
rooms.room_name,
bookings.id AS booking_id

FROM payments

JOIN bookings
ON payments.booking_id = bookings.id

JOIN users
ON bookings.user_id = users.id

JOIN rooms
ON bookings.room_id = rooms.id

ORDER BY payments.id DESC
");

?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Data Pembayaran</title>

<link rel="stylesheet" href="../assets/style.css">

</head>

<body>

<div class="sidebar">

<h2>HOSTEL</h2>

<a href="dashboard.php">Dashboard</a>
<a href="kamar.php">Kamar</a>
<a href="boking.php">Booking</a>
<a href="pembayaran.php">Pembayaran</a>
<a href="../logout.php">Logout</a>

</div>

<div class="content">

<div class="card">

<h2>Data Pembayaran</h2>

<table class="table">

<tr>

<th>ID</th>
<th>Nama User</th>
<th>Kamar</th>
<th>Jumlah</th>
<th>Bukti Bayar</th>
<th>Status</th>
<th>Aksi</th>

</tr>

<?php while($row = $query->fetch()): ?>

<tr>

<td><?= $row['id']; ?></td>

<td><?= $row['fullname']; ?></td>

<td><?= $row['room_name']; ?></td>

<td>
Rp <?= number_format($row['amount']); ?>
</td>

<td>

<?php if($row['payment_proof']){ ?>

<img
src="../assets/upload/<?= $row['payment_proof']; ?>"
width="120">

<?php }else{ ?>

Belum Upload

<?php } ?>

</td>

<td>

<?= $row['status']; ?>

</td>

<td>

<b>Booking ID :</b> <?= $row['booking_id']; ?><br>
<b>Payment ID :</b> <?= $row['id']; ?><br><br>

<?php if($row['status']=="pending"){ ?>

<a
href="verifikasi.php?id=<?= $row['id']; ?>&booking=<?= $row['booking_id']; ?>"
class="btn">

Verifikasi

</a>

<?php }else{ ?>

✔ Sudah Diverifikasi

<?php } ?>

</td>

</tr>

<?php endwhile; ?>

</table>

</div>

</div>

</body>
</html>