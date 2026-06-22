<?php
session_start();

if(!isset($_SESSION['user_id'])){

    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Dashboard Owner</title>

<link rel="stylesheet"
href="../assets/style.css">

</head>
<body>

<div class="sidebar">

<h2>HOSTEL</h2>

<a href="dashboard.php">
Dashboard
</a>

<a href="kamar.php">
Data Kamar
</a>

<a href="boking.php">
Booking
</a>

<a href="pembayaran.php">
Pembayaran
</a>

<a href="../logout.php">
Logout
</a>

</div>

<div class="content">

<div class="card">

<h2>
Selamat Datang,
<?= $_SESSION['name']; ?>
</h2>

<p>
Dashboard Owner Hostel
</p>

</div>

</div>

</body>
</html>