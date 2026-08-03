<?php
session_start();
require '../config.php';

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=? AND role='owner'");
    $stmt->execute([$email]);

    $user = $stmt->fetch();

    if($user && password_verify($password, $user['password'])){

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['fullname'];
        $_SESSION['role'] = $user['role'];

        header("Location: dashboard.php");
        exit;

    }else{

        $error = "Email atau Password Salah!";

    }
}
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<title>Login Owner</title>

<link rel="stylesheet" href="../assets/style.css">

<style>

body{
    margin:0;
    font-family:Segoe UI,sans-serif;
    background:linear-gradient(135deg,#2563eb,#1e40af);
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.login-box{
    width:420px;
    background:#fff;
    padding:35px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,.2);
}

.login-box h2{
    text-align:center;
    margin-bottom:30px;
}

input{
    width:100%;
    padding:14px;
    margin-bottom:20px;
    border:1px solid #ddd;
    border-radius:10px;
    box-sizing:border-box;
}

button{
    width:100%;
    padding:14px;
    border:none;
    border-radius:10px;
    background:#2563eb;
    color:white;
    font-size:16px;
    cursor:pointer;
}

button:hover{
    background:#1d4ed8;
}

.error{
    color:red;
    text-align:center;
    margin-bottom:15px;
}

</style>

</head>
<body>

<div class="login-box">

<h2>🔐 LOGIN OWNER STAYKU</h2>

<?php if(isset($error)): ?>
<p class="error"><?= $error ?></p>
<?php endif; ?>

<form method="POST">

<input
type="email"
name="email"
placeholder="Email"
required>

<input
type="password"
name="password"
placeholder="Password"
required>

<button type="submit" name="login">
Login Owner
</button>

</form>

</div>

</body>
</html>