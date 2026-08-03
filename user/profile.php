<?php

session_start();
require '../config.php';

$user_id = $_SESSION['user_id'];

$user = $pdo->prepare("SELECT * FROM users WHERE id=?");
$user->execute([$user_id]);
$user = $user->fetch();

$totalBooking = $pdo->prepare("
SELECT COUNT(*)
FROM bookings
WHERE user_id=?
");
$totalBooking->execute([$user_id]);

$totalBooking = $totalBooking->fetchColumn();

$lunas = $pdo->prepare("
SELECT COUNT(*)
FROM bookings
WHERE user_id=? AND status='Lunas'
");
$lunas->execute([$user_id]);

$lunas = $lunas->fetchColumn();

$pending = $pdo->prepare("
SELECT COUNT(*)
FROM bookings
WHERE user_id=? AND status='pending'
");
$pending->execute([$user_id]);

$pending = $pending->fetchColumn();

$batal = $pdo->prepare("
SELECT COUNT(*)
FROM bookings
WHERE user_id=? AND status='cancel'
");
$batal->execute([$user_id]);

$batal = $batal->fetchColumn();

$stmt = $pdo->prepare(
"SELECT * FROM users WHERE id=?"
);

$stmt->execute([
$_SESSION['user_id']
]);

$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html>
<head>

<title>Profil</title>

<link rel="stylesheet"
href="../assets/user.css">

</head>
<body>

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

<div class="profile-card">

<div class="avatar">
👤
</div>


<h2>
<?= $user['fullname']; ?>
</h2>


<p>
 <?= $user['email']; ?>
</p>


<hr>


<p>
 <b>No HP</b> : 
<?= $user['phone'] ?: '-'; ?>
</p>


<p>
 <b>Role</b> : 
User
</p>


<p>
 <b>Bergabung</b> :
<?= date('d F Y',strtotime($user['created_at'])); ?>
</p>



<div class="profile-button">

<a href="profile.php" class="btn">
 Edit Profil
</a>

<a href="profile.php" class="btn btn-danger">
 Password
</a>

</div>

</div>


</div>

</body>
</html>