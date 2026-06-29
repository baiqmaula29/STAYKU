<?php

require '../config.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("
SELECT * FROM rooms
WHERE id=?
");

$stmt->execute([$id]);

$room = $stmt->fetch();

if(isset($_POST['update'])){

    $stmt = $pdo->prepare("
    UPDATE rooms
    SET
        room_name=?,
        room_number=?,
        daily_price=?,
        weekly_price=?,
        status=?
    WHERE id=?
    ");

    $stmt->execute([

        $_POST['room_name'],
        $_POST['room_number'],
        $_POST['daily_price'],
        $_POST['weekly_price'],
        $_POST['status'],
        $id

    ]);

    header("Location:kamar.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Edit Kamar</title>

<link rel="stylesheet" href="../assets/style.css">

</head>

<body>

<div class="content">

<div class="card">

<h2>Edit Kamar</h2>

<form method="POST">

<input
type="text"
name="room_name"
value="<?= $room['room_name']; ?>"
class="form-control"
required>

<br>

<input
type="text"
name="room_number"
value="<?= $room['room_number']; ?>"
class="form-control"
required>

<br>

<input
type="number"
name="daily_price"
value="<?= $room['daily_price']; ?>"
class="form-control"
placeholder="Harga Harian"
required>

<br>

<input
type="number"
name="weekly_price"
value="<?= $room['weekly_price']; ?>"
class="form-control"
placeholder="Harga Mingguan"
required>

<br>

<select
name="status"
class="form-control">

<option value="available" <?= $room['status']=="available" ? "selected" : ""; ?>>
Tersedia
</option>

<option value="occupied" <?= $room['status']=="occupied" ? "selected" : ""; ?>>
Terisi
</option>

</select>

<br>

<button
type="submit"
name="update"
class="btn btn-primary">

Update

</button>

</form>

</div>

</div>

</body>
</html>