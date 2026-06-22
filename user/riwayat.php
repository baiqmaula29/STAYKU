<?php

session_start();
require '../config.php';

$stmt = $pdo->prepare("
SELECT
bookings.*,
rooms.room_name

FROM bookings

JOIN rooms
ON bookings.room_id = rooms.id

WHERE bookings.user_id=?

ORDER BY bookings.id DESC
");

$stmt->execute([
$_SESSION['user_id']
]);

?>

<!DOCTYPE html>
<html>
<head>

<title>Riwayat Booking</title>

<link rel="stylesheet"
href="../assets/user.css">

</head>
<body>

<div class="navbar">

<div class="logo">
HOSTELKU
</div>

</div>

<div class="container">

<h2 class="section-title">
Riwayat Booking
</h2>

<?php while($row = $stmt->fetch()): ?>

<div class="booking-card">

<h3>
<?= $row['room_name']; ?>
</h3>

<p>
<?= $row['check_in']; ?>
s/d
<?= $row['check_out']; ?>
</p>

<p>
Rp
<?= number_format($row['total_price']); ?>
</p>

<br>

<span class="status pending">
<?= $row['status']; ?>
</span>

</div>

<?php endwhile; ?>

</div>

</body>
</html>