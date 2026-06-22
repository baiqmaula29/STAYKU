<?php

session_start();
require '../config.php';

$id = $_GET['room_id'];

$stmt = $pdo->prepare(
"SELECT * FROM rooms WHERE id=?"
);

$stmt->execute([$id]);

$room = $stmt->fetch();

if(isset($_POST['boking'])){

$pdo->prepare("
INSERT INTO bookings
(
user_id,
room_id,
check_in,
check_out,
total_price,
status
)
VALUES
(?,?,?,?,?,'pending')
")->execute([

$_SESSION['user_id'],
$id,
$_POST['check_in'],
$_POST['check_out'],
$room['price']

]);

header("Location: riwayat.php");
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Booking Kamar</title>

<link rel="stylesheet"
href="../assets/user.css">

</head>
<body>

<div class="container">

<div class="profile-card">

<h2>Booking Kamar</h2>

<br>

<h3>
<?= $room['room_name']; ?>
</h3>

<p>
Rp <?= number_format($room['price']); ?>
</p>

<br>

<form method="POST">

<label>Check In</label>

<input
type="date"
name="check_in"
class="form-control"
required>

<label>Check Out</label>

<input
type="date"
name="check_out"
class="form-control"
required>

<button
class="btn"
name="boking">

Konfirmasi Booking

</button>

</form>

</div>

</div>

</body>
</html>