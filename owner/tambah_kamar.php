<?php

session_start();
require '../config.php';

if(isset($_POST['simpan'])){

    $nama = $_POST['room_name'];
    $nomor = $_POST['room_number'];
    $harga = $_POST['price'];
    $status = $_POST['status'];

    $foto = $_FILES['photo']['name'];
    $tmp = $_FILES['photo']['tmp_name'];

    move_uploaded_file(
        $tmp,
        "../assets/upload/".$foto
    );

    $stmt = $pdo->prepare("
    INSERT INTO rooms
    (room_name,room_number,price,status,photo)
    VALUES
    (?,?,?,?,?)
    ");

    $stmt->execute([
        $nama,
        $nomor,
        $harga,
        $status,
        $foto
    ]);

    header("Location:kamar.php");
}
?>

<link rel="stylesheet"
href="../assets/style.css">

<div class="content">

<div class="card">

<h2>Tambah Kamar</h2>

<form method="POST"
enctype="multipart/form-data">

<input type="text"
name="room_name"
placeholder="Nama Kamar"
class="form-control">

<br>

<input type="text"
name="room_number"
placeholder="Nomor Kamar"
class="form-control">

<br>

<input type="number"
name="price"
placeholder="Harga"
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

<input
type="file"
name="photo">

<br><br>

<button
name="simpan"
class="btn btn-primary">

Simpan

</button>

</form>

</div>

</div>