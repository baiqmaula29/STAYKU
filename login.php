<?php
session_start();
require 'config.php';

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare(
        "SELECT * FROM users WHERE email=?"
    );

    $stmt->execute([$email]);

    $user = $stmt->fetch();

    if($user){

        if(password_verify(
            $password,
            $user['password']
        )){

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['fullname'];
            $_SESSION['role'] = $user['role'];

            if($user['role'] == 'owner'){

                header(
                    "Location: owner/dashboard.php"
                );

            }else{

                header(
                    "Location: user/dashboard.php"
                );

            }

            exit;
        }
    }

    $error = "Email atau Password Salah";
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Login Hostel</title>

<link rel="stylesheet"
href="assets/style.css">

</head>
<body>

<div class="login-container">

<div class="login-card">

<h2>HOSTEL LOGIN</h2>

<?php if(isset($error)): ?>

<p style="color:red">
<?= $error ?>
</p>

<?php endif; ?>

<form method="POST">

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
name="login"
class="btn btn-primary">

Login

</button>

</form>

<p class="text-center mt-2">

Belum punya akun?

<a href="register.php">

Register

</a>

</p>

</div>

</div>

</body>
</html>