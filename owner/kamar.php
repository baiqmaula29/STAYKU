<?php
session_start();
require '../config.php';

$data = $pdo->query("SELECT * FROM rooms ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Data Kamar</title>
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

<h2>Data Kamar</h2>

<br>

<a href="tambah_kamar.php" class="btn-success">
Tambah Kamar
</a>

<br><br>

<table class="table">

<tr>
    <th>Foto</th>
    <th>No. Kamar</th>
    <th>Nama Kamar</th>
    <th>Tipe</th>
    <th>Harga Harian</th>
    <th>Harga Bulanan</th>
    <th>Aksi</th>
</tr>

<?php while($room = $data->fetch()): ?>

<tr>

<td>
<img src="../assets/upload/<?= $room['photo']; ?>" width="80">
</td>

<td><?= $room['room_number']; ?></td>

<td><?= $room['room_name']; ?></td>

<td><?= $room['room_type']; ?></td>

<td>
Rp <?= number_format($room['daily_price']); ?>
</td>

<td>
Rp <?= number_format($room['monthly_price']); ?>

<td>
    <a href="edit_kamar.php?id=<?= $room['id']; ?>" class="btn-warning">Edit</a>

    <a href="foto_kamar.php?id=<?= $room['id']; ?>" class="btn-info">Foto</a>

    <a href="hapus_kamar.php?id=<?= $room['id']; ?>"
       class="btn-danger"
       onclick="return confirm('Hapus data?')">
       Hapus
    </a>
</td>


</tr>

<?php endwhile; ?>

</table>

</div>

</div>

</body>
</html>