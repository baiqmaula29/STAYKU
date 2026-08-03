<?php

session_start();
require '../config.php';

if(isset($_POST['simpan'])){
    $nama = $_POST['room_name'];
    $nomor = $_POST['room_number'];
    $harga_harian = $_POST['daily_price'];
    $harga_bulanan = $_POST['monthly_price'];
    $tipe = $_POST['room_type'];
    $status = $_POST['status'];

    $foto = $_FILES['photo']['name'];
    $tmp = $_FILES['photo']['tmp_name'];

    move_uploaded_file(
        $tmp,
        "../assets/upload/".$foto
    );

    $stmt = $pdo->prepare("
    INSERT INTO rooms
    (
        room_name,
room_number,
daily_price,
monthly_price,
room_type,
status,
photo
    )
  VALUES
(?,?,?,?,?,?,?)
    ");

    $stmt->execute([
        $nama,
        $nomor,
        $harga_harian,
        $harga_bulanan,
        $tipe,
        $status,
        $foto
    ]);

    header("Location:kamar.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Tambah Kamar</title>

<link rel="stylesheet" href="../assets/owner.css?v=1">

</head>

<body>

<div class="content">

<div class="card">

<h2>Tambah Kamar</h2>

<form method="POST" enctype="multipart/form-data">

<input
type="text"
name="room_name"
placeholder="Nama Kamar"
class="form-control"
required>

<br>

<input
type="text"
name="room_number"
placeholder="Nomor Kamar"
class="form-control"
required>

<br>

<select
name="room_type"
class="form-control"
required>

<option value="AC"> AC</option>

<option value="Non AC"> Non AC</option>

</select>

<br>

<input
type="number"
name="daily_price"
placeholder="Harga Harian"
class="form-control"
required>

<br>

<input
type="number"
name="monthly_price"
placeholder="Harga Bulanan"
class="form-control"
required>

<br>

<select
name="status"
class="form-control">

<option value="available">Tersedia</option>

<option value="occupied">Terisi</option>

</select>

<br>

<input
type="file"
name="photo"
required>

<br><br>

<button
type="submit"
name="simpan"
class="btn btn-primary">

Simpan

</button>

</form>

</div>

</div>

</body>
</html>