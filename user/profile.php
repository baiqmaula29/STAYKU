<?php

session_start();
require '../config.php';

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
StayKu Mandalika
</div>

</div>

<div class="container">

<div class="profile-card">

<h2>Profil Saya</h2>

<br>

<p>
<b>Nama :</b>
<?= $user['fullname']; ?>
</p>

<p>
<b>Email :</b>
<?= $user['email']; ?>
</p>

<p>
<b>Role :</b>
<?= $user['role']; ?>
</p>

</div>

</div>

</body>
</html>