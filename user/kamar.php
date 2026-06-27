<?php

session_start();
require '../config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}

$data = $pdo->query("
SELECT *
FROM rooms
WHERE status='available'
");

?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Daftar Kamar</title>

<link rel="stylesheet" href="../assets/user.css">

</head>

<body>

<!-- NAVBAR -->

<div class="navbar">

    <div class="logo">
        🏨 HostelKu
    </div>

    <ul class="nav-menu">

        <li>
            <a href="dashboard.php">
                🏠 Home
            </a>
        </li>

        <li>
            <a href="kamar.php">
                🛏️ Kamar
            </a>
        </li>

        <li>
            <a href="riwayat.php">
                📋 Riwayat
            </a>
        </li>

        <li>
            <a href="profile.php">
                👤 Profil
            </a>
        </li>

        <li>
            <a href="../logout.php" class="logout">
                🚪 Logout
            </a>
        </li>

    </ul>

</div>

<!-- CONTENT -->

<div class="container">

<h2 class="section-title">
🛏️ Daftar Kamar
</h2>

<div class="room-grid">

<?php while($room = $data->fetch()): ?>

<div class="room-card">

<img
src="../assets/upload/<?= $room['photo']; ?>"
alt="<?= $room['room_name']; ?>">

<div class="room-body">

<h3>
<?= $room['room_name']; ?>
</h3>

<p>
📌 Nomor Kamar :
<b><?= $room['room_number']; ?></b>
</p>

<p class="price">
💰 Rp <?= number_format($room['price']); ?>
</p>

<p>
✅ Status :
<?= ucfirst($room['status']); ?>
</p>

<br>

<a
href="booking.php?room_id=<?= $room['id']; ?>"
class="btn">

🛏️ Booking Sekarang

</a>

</div>

</div>

<?php endwhile; ?>

</div>

</div>

</body>
</html>