<?php
session_start();
require '../config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}

if(!isset($_GET['booking_id'])){
    die("Booking tidak ditemukan.");
}

$booking_id = $_GET['booking_id'];

$stmt = $pdo->prepare("
SELECT bookings.*, rooms.room_name
FROM bookings
JOIN rooms ON bookings.room_id = rooms.id
WHERE bookings.id=?
");

$stmt->execute([$booking_id]);
$booking = $stmt->fetch();

if(!$booking){
    die("Data booking tidak ditemukan.");
}

if(isset($_POST['upload'])){

    $namaFile = time().'_'.$_FILES['bukti']['name'];
    $tmp = $_FILES['bukti']['tmp_name'];

    move_uploaded_file(
        $tmp,
        "../assets/upload/".$namaFile
    );

    $simpan = $pdo->prepare("
    INSERT INTO payments
    (
        booking_id,
        amount,
        payment_proof,
        status
    )
    VALUES
    (
        ?,
        ?,
        ?,
        'pending'
    )
    ");
    
    $simpan->execute([
        $booking_id,
        $booking['total_price'],
        $namaFile
    ]);

    echo "<script>
    alert('Pembayaran berhasil dikirim.');
    window.location='riwayat.php';
    </script>";
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Pembayaran</title>

<link rel="stylesheet" href="../assets/user.css">

</head>

<body>

<div class="navbar">

<div class="logo">
🏨 StayKu Mandalika
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

<h2>Pembayaran Booking</h2>

<br>

<h3><?= $booking['room_name']; ?></h3>

<p>Total Pembayaran</p>

<h2 style="color:#2563eb;">
Rp <?= number_format($booking['total_price']); ?>
</h2>

<hr><br>

<h3>Transfer Ke</h3>

<p><b>Bank BCA</b></p>

<p>No Rekening :</p>

<h2>1234567890</h2>

<p>a.n HostelKu</p>

<br>

<form method="POST" enctype="multipart/form-data">

<label>Upload Bukti Transfer</label>

<input
type="file"
name="bukti"
class="form-control"
required>

<br>

<button
type="submit"
name="upload"
class="btn">

Kirim Pembayaran

</button>

</form>

</div>

</div>

</body>
</html>