<?php
session_start();
require '../config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
$stmt->execute([$id]);
$user = $stmt->fetch();


if(isset($_POST['update'])){

    $fullname = $_POST['fullname'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];


    $update = $pdo->prepare("
        UPDATE users 
        SET fullname=?, email=?, phone=?
        WHERE id=?
    ");

    $update->execute([
        $fullname,
        $email,
        $phone,
        $id
    ]);


    echo "
    <script>
    alert('Profil berhasil diperbarui');
    window.location='profile.php';
    </script>
    ";

}

?>


<!DOCTYPE html>
<html>
<head>
<title>Edit Profil - StayKu</title>

<link rel="stylesheet" href="../assets/user.css">

</head>


<body>


<div class="profile-card">


<h2>
✏ Edit Profil
</h2>


<form method="POST">


<p>
Nama Lengkap
</p>

<input 
type="text" 
name="fullname"
value="<?= $user['fullname']; ?>"
required>


<p>
Email
</p>

<input 
type="email"
name="email"
value="<?= $user['email']; ?>"
required>


<p>
No HP
</p>

<input 
type="text"
name="phone"
value="<?= $user['phone']; ?>">



<button 
name="update"
class="btn">

Simpan

</button>


<a href="profile.php" class="btn btn-danger">
Kembali
</a>


</form>


</div>


</body>
</html>