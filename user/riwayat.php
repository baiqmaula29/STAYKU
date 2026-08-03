<?php

session_start();
require '../config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}

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

<meta charset="UTF-8">

<title>Riwayat Booking</title>

<link rel="stylesheet" href="../assets/user.css">

</head>

<body>

<!-- Navbar -->

<div class="navbar">

    <div class="logo">
        🏨 StayKu Mandalika
    </div>

    <ul class="nav-menu">

        <li><a href="dashboard.php"> Home</a></li>

        <li><a href="kamar.php"> Kamar</a></li>

        <li><a href="riwayat.php"> Riwayat</a></li>

        <li><a href="profile.php"> Profil</a></li>

        <li><a href="../logout.php" class="logout"> Logout</a></li>

    </ul>

</div>

<div class="container">

<h2 class="section-title">
📋 Riwayat Booking
</h2>

<?php while($row = $stmt->fetch()): ?>

<div class="booking-card">

<h3>
<?= $row['room_name']; ?>
</h3>

<p>
<b>Check In :</b>
<?= $row['check_in']; ?>
</p>

<p>
<b>Check Out :</b>
<?= $row['check_out']; ?>
</p>

<p>
<b>Total :</b>

Rp <?= number_format($row['total_price']); ?>

</p>

<br>

<?php

$class="pending";

if($row['status']=="Lunas"){

$class="paid";

}

?>

<span class="status <?= $class; ?>">

<?= $row['status']; ?>

</span>

<br><br>

<?php if($row['status']=="pending"){ ?>

<a
href="pembayaran.php?booking_id=<?= $row['id']; ?>"
class="btn">

💳 Bayar

</a>

<a
href="batal_booking.php?id=<?= $row['id']; ?>"
class="btn btn-danger"
onclick="return confirm('Yakin ingin membatalkan booking ini?')">

❌ Batal Booking

</a>

<?php } ?>

</div>

<?php endwhile; ?>

</div>

</body>
</html>