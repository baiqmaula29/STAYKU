<?php

session_start();
require '../config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}

// Otomatis mengubah kamar menjadi tersedia jika masa sewa sudah habis
$pdo->query("
UPDATE rooms
JOIN bookings
ON rooms.id = bookings.room_id
SET rooms.status='available'
WHERE bookings.check_out < CURDATE()
AND bookings.status='Lunas'
");

$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

$stmt = $pdo->prepare("
SELECT *
FROM rooms
WHERE room_name LIKE ?
OR room_number LIKE ?
ORDER BY id DESC
");

$stmt->execute([
"%$cari%",
"%$cari%"
]);

$data = $stmt;
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Daftar Kamar</title>

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

<h2 class="section-title">
🛏️ Daftar Kamar
</h2>

<form method="GET" style="margin-bottom:25px;display:flex;gap:10px;">

<input
type="text"
name="cari"
class="form-control"
placeholder="🔍 Cari nama atau nomor kamar..."
value="<?= htmlspecialchars($cari); ?>">

<button class="btn">
Cari
</button>

<a href="kamar.php" class="btn" style="background:#6b7280;">
Reset
</a>

</form>

<div class="room-grid">

<?php while($room = $data->fetch()): ?>

    <div class="room-card">

<a href="booking.php?room_id=<?= $room['id']; ?>">

<img
src="../assets/upload/<?= $room['photo']; ?>"
alt="<?= $room['room_name']; ?>"
style="
width:100%;
height:160px;
object-fit:cover;
display:block;
">

</a>

<div class="room-body">

<h3>
<?= $room['room_name']; ?>
</h3>

<p>
📌 Nomor Kamar :
<b><?= $room['room_number']; ?></b>
</p>

<p class="price">
💰 Harian :
Rp <?= number_format($room['daily_price']); ?>
</p>

<p class="price">
📅 Mingguan :
Rp <?= number_format($room['weekly_price']); ?>
</p>

<?php if($room['status']=="available"){ ?>

<p style="color:green;font-weight:bold;">
🟢 Kamar Kosong
</p>
<a href="booking.php?room_id=<?= $room['id']; ?>" class="btn">
    🛏️ Booking Sekarang
</a>

<?php }else{ ?>

<p style="color:red;font-weight:bold;">
🔴 Kamar Terisi
</p>

<button
class="btn"
style="background:red;"
disabled>

Kamar Sedang Terisi

</button>

<?php } ?>

</div>

</div>

<?php endwhile; ?>

</div>

</div>

</body>
</html>