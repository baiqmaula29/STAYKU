<?php

session_start();
require '../config.php';

$query = $pdo->query("
SELECT
bookings.*,
users.fullname,
rooms.room_name

FROM bookings

JOIN users
ON bookings.user_id = users.id

JOIN rooms
ON bookings.room_id = rooms.id

ORDER BY bookings.id DESC
");

?>

<!DOCTYPE html>
<html>
<head>
<title>Data Booking</title>
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

<div class="content">

<div class="card">

<h2>Data Booking</h2>

<table class="table">

<tr>
<th>ID</th>
<th>Nama User</th>
<th>Kamar</th>
<th>Check In</th>
<th>Check Out</th>
<th>Total</th>
<th>Status</th>
</tr>

<?php while($row = $query->fetch()): ?>

<tr>

<td><?= $row['id']; ?></td>

<td><?= $row['fullname']; ?></td>

<td><?= $row['room_name']; ?></td>

<td><?= $row['check_in']; ?></td>

<td><?= $row['check_out']; ?></td>

<td>
Rp <?= number_format($row['total_price']); ?>
</td>

<td><?= $row['status']; ?></td>

</tr>

<?php endwhile; ?>

</table>

</div>

</div>

</body>
</html>