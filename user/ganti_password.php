<?php

session_start();
require '../config.php';


if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}


$id = $_SESSION['user_id'];


if(isset($_POST['ubah'])){


$password_lama = $_POST['password_lama'];
$password_baru = $_POST['password_baru'];



$stmt = $pdo->prepare("
SELECT password FROM users WHERE id=?
");

$stmt->execute([$id]);

$user = $stmt->fetch();



if(password_verify($password_lama,$user['password'])){


$newPassword = password_hash(
$password_baru,
PASSWORD_DEFAULT
);



$update = $pdo->prepare("
UPDATE users 
SET password=?
WHERE id=?
");


$update->execute([
$newPassword,
$id
]);



echo "
<script>
alert('Password berhasil diganti');
window.location='profile.php';
</script>
";



}else{


echo "
<script>
alert('Password lama salah');
</script>
";

}


}


?>


<!DOCTYPE html>
<html>

<head>

<title>Ganti Password</title>

<link rel="stylesheet" href="../assets/user.css">

</head>


<body>


<div class="profile-card">


<h2>
🔒 Ganti Password
</h2>



<form method="POST">


<p>
Password Lama
</p>

<input 
type="password"
name="password_lama"
required>



<p>
Password Baru
</p>

<input 
type="password"
name="password_baru"
required>



<button 
class="btn"
name="ubah">

Simpan Password

</button>



<a href="profile.php" class="btn btn-danger">
Kembali
</a>



</form>


</div>



</body>

</html>