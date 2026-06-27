<?php

session_start();
require '../config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}

$id = $_GET['room_id'];

$stmt = $pdo->prepare("SELECT * FROM rooms WHERE id=?");
$stmt->execute([$id]);

$room = $stmt->fetch();

if(isset($_POST['booking'])){

    $rent_type = $_POST['rent_type'];
    $duration  = $_POST['duration'];

    if($rent_type=="harian"){

        $total = $room['daily_price'] * $duration;

    }else{

        $total = $room['weekly_price'] * $duration;

    }

    $pdo->prepare("
    INSERT INTO bookings
    (
        user_id,
        room_id,
        rent_type,
        duration,
        check_in,
        check_out,
        total_price,
        status
    )
    VALUES
    (?,?,?,?,?,?,?,'pending')
    ")->execute([

        $_SESSION['user_id'],
        $id,
        $rent_type,
        $duration,
        $_POST['check_in'],
        $_POST['check_out'],
        $total

    ]);

    header("Location: riwayat.php");
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Booking Kamar</title>

<link rel="stylesheet" href="../assets/user.css">

</head>

<body>

<div class="navbar">

<div class="logo">
🏨 HostelKu
</div>

<ul class="nav-menu">

<li><a href="dashboard.php">🏠 Home</a></li>

<li><a href="kamar.php">🛏️ Kamar</a></li>

<li><a href="riwayat.php">📋 Riwayat</a></li>

<li><a href="profile.php">👤 Profil</a></li>

<li><a href="../logout.php" class="logout">🚪 Logout</a></li>

</ul>

</div>

<div class="container">

<div class="profile-card">

<h2>Booking Kamar</h2>

<br>

<h3><?= $room['room_name']; ?></h3>

<br>

<form method="POST">

<label>Jenis Sewa</label>

<select
name="rent_type"
class="form-control"
required>

<option value="harian">
Harian
</option>

<option value="mingguan">
Mingguan
</option>

</select>

<label>Lama Sewa</label>

<input
type="number"
name="duration"
class="form-control"
min="1"
required>

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
type="submit"
name="booking"
class="btn">

Konfirmasi Booking

</button>

</form>

</div>

</div>

</body>
</html>