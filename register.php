<?php
session_start();
require 'config.php';

if(isset($_POST['register'])){

    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Cek email sudah ada atau belum
    $cek = $pdo->prepare(
        "SELECT id FROM users WHERE email=?"
    );

    $cek->execute([$email]);

    if($cek->rowCount() > 0){

        $error = "Email sudah terdaftar!";

    }else{

        $hash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $stmt = $pdo->prepare("
        INSERT INTO users
        (fullname,email,password,role)
        VALUES
        (?,?,?,'user')
        ");

        $stmt->execute([
            $fullname,
            $email,
            $hash
        ]);

        header("Location: login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Register StayKu Mandalika/title>

<link rel="stylesheet"
href="assets/style.css">

</head>
<body>

<div class="login-container">

<div class="login-card">

<h2>REGISTER</h2>

<?php if(isset($error)): ?>
<p style="color:red;">
    <?= $error ?>
</p>
<?php endif; ?>

<form method="POST">

<div class="form-group">

<input
type="text"
name="fullname"
class="form-control"
placeholder="Nama Lengkap"
required>

</div>

<div class="form-group">

<input
type="email"
name="email"
class="form-control"
placeholder="Email"
required>

</div>

<div class="form-group">

<input
type="password"
name="password"
class="form-control"
placeholder="Password"
required>

</div>

<button
type="submit"
name="register"
class="btn btn-primary">

Register

</button>

</form>

<p class="text-center mt-2">

Sudah punya akun?

<a href="login.php">
Login
</a>

</p>

</div>

</div>

</body>
</html>