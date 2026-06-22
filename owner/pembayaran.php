<?php

session_start();
require '../config.php';

$query = $pdo->query("
SELECT
payments.*,
users.fullname

FROM payments

JOIN bookings
ON payments.booking_id = bookings.id

JOIN users
ON bookings.user_id = users.id

ORDER BY payments.id DESC
");

?>

<!DOCTYPE html>
<html>
<head>
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
<th>Jumlah</th>
<th>Bukti Bayar</th>
<th>Status</th>
</tr>

<?php while($row = $query->fetch()): ?>

<tr>

<td><?= $row['id']; ?></td>

<td><?= $row['fullname']; ?></td>

<td>
Rp <?= number_format($row['amount']); ?>
</td>

<td>

<?php if($row['payment_proof']) : ?>

<img
src="../assets/upload/<?= $row['payment_proof']; ?>"
width="100">

<?php endif; ?>

</td>

<td><?= $row['status']; ?></td>

</tr>

<?php endwhile; ?>

</table>

</div>

</div>

</body>
</html>