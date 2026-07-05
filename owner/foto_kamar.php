<?php

session_start();
require '../config.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM rooms WHERE id=?");
$stmt->execute([$id]);
$room = $stmt->fetch();

if(isset($_POST['upload'])){

    foreach($_FILES['photos']['name'] as $key=>$name){

        if($name=="") continue;

        $tmp = $_FILES['photos']['tmp_name'][$key];

        move_uploaded_file(
            $tmp,
            "../assets/upload/".$name
        );

        $pdo->prepare("
        INSERT INTO room_photos(room_id,photo)
        VALUES(?,?)
        ")->execute([
            $id,
            $name
        ]);

    }

    header("Location: foto_kamar.php?id=".$id);
    exit;
}

$data = $pdo->prepare("
SELECT *
FROM room_photos
WHERE room_id=?
");

$data->execute([$id]);

?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Foto Kamar</title>

<link rel="stylesheet" href="../assets/style.css">

</head>

<body>

<div class="content">

<div class="card">

<h2>Foto Kamar <?= $room['room_name']; ?></h2>

<form method="POST" enctype="multipart/form-data">

<input
type="file"
name="photos[]"
multiple
required>

<br><br>

<button
name="upload"
class="btn">

Upload Foto

</button>

</form>

<br>

<table class="table">

<tr>

<th>Foto</th>
<th>Aksi</th>

</tr>

<?php while($foto=$data->fetch()): ?>

<tr>

<td>

<img
src="../assets/upload/<?= $foto['photo']; ?>"
width="180">

</td>

<td>

<a
href="hapus_foto.php?id=<?= $foto['id']; ?>&room=<?= $id; ?>"
class="btn-danger"
onclick="return confirm('Hapus foto?')">

Hapus

</a>

</td>

</tr>

<?php endwhile; ?>

</table>

<br>

<a
href="kamar.php"
class="btn">

Kembali

</a>

</div>

</div>

</body>
</html>