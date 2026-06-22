<?php

require '../config.php';

$id = $_GET['id'];

$stmt = $pdo->prepare(
"SELECT * FROM rooms WHERE id=?"
);

$stmt->execute([$id]);

$room = $stmt->fetch();

if(isset($_POST['update'])){

    $stmt = $pdo->prepare("
    UPDATE rooms
    SET
    room_name=?,
    room_number=?,
    price=?,
    status=?
    WHERE id=?
    ");

    $stmt->execute([

        $_POST['room_name'],
        $_POST['room_number'],
        $_POST['price'],
        $_POST['status'],
        $id

    ]);

    header("Location:kamar.php");
}
?>

<link rel="stylesheet"
href="../assets/style.css">

<div class="content">

<div class="card">

<h2>Edit Kamar</h2>

<form method="POST">

<input
type="text"
name="room_name"
value="<?= $room['room_name']; ?>"
class="form-control">

<br>

<input
type="text"
name="room_number"
value="<?= $room['room_number']; ?>"
class="form-control">

<br>

<input
type="number"
name="price"
value="<?= $room['price']; ?>"
class="form-control">

<br>

<select
name="status"
class="form-control">

<option value="available">
Tersedia
</option>

<option value="occupied">
Terisi
</option>

</select>

<br>

<button
name="update"
class="btn btn-primary">

Update

</button>

</form>

</div>

</div>