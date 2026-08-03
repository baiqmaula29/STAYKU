<?php

session_start();
require '../config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}

$id = isset($_GET['room_id']) ? $_GET['room_id'] : 0;

// Ambil data kamar
$stmt = $pdo->prepare("SELECT * FROM rooms WHERE id=?");
$stmt->execute([$id]);
$room = $stmt->fetch();

if(!$room){
    die("Kamar tidak ditemukan.");
}

// Ambil foto tambahan
$allPhotos = [];

try{

    $photos = $pdo->prepare("
    SELECT photo
    FROM room_photos
    WHERE room_id=?
    ");

    $photos->execute([$id]);

    $allPhotos = $photos->fetchAll(PDO::FETCH_ASSOC);

}catch(Exception $e){

    $allPhotos = [];

}

if(isset($_POST['booking'])){

    $rent_type = $_POST['rent_type'];
    $duration  = $_POST['duration'];

    if($rent_type=="harian"){
        $total = $room['daily_price'] * $duration;
    }else{
        $total = $room['monthly_price'] * $duration;
    }

    $pdo->prepare("
    INSERT INTO bookings
    (
        user_id,
        room_id,
        rent_type,
        duration,
        check_in,
        check_out,
        total_price,
        status
    )
    VALUES
    (?,?,?,?,?,?,?,'pending')
    ")->execute([

        $_SESSION['user_id'],
        $id,
        $rent_type,
        $duration,
        $_POST['check_in'],
        $_POST['check_out'],
        $total

    ]);

    header("Location: riwayat.php");
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Booking Kamar</title>

<link rel="stylesheet" href="../assets/user.css?v=<?= time(); ?>">

<style>

.gallery{
    width:100%;
    text-align:center;
    margin:20px 0;
}

#mainImage{
    width:450px;
    height:280px;
    object-fit:cover;
    border-radius:12px;
    border:1px solid #ddd;
    box-shadow:0 4px 10px rgba(0,0,0,.2);
}

.thumbs{
    display:flex;
    justify-content:center;
    gap:10px;
    flex-wrap:wrap;
    margin-top:15px;
}

.thumbs img{
    width:90px;
    height:70px;
    object-fit:cover;
    border-radius:8px;
    cursor:pointer;
    border:2px solid #ddd;
}

.thumbs img:hover{
    border-color:#2563eb;
}

</style>

</head>

<body>

<div class="navbar">

<div class="logo">
🏨StayKu Mandalika
</div>

<ul class="nav-menu">

<li><a href="dashboard.php">Beranda</a></li>

<li><a href="kamar.php"> Kamar</a></li>

<li><a href="riwayat.php"> Riwayat</a></li>

<li><a href="profile.php"> Profil</a></li>

<li><a href="../logout.php"> Logout</a></li>

</ul>

</div>

<div class="container">

<div class="profile-card">

<h2 style="text-align:center;">Booking Kamar</h2>

<h3 style="text-align:center;">
<?= $room['room_name']; ?>
</h3>

<div class="gallery">

<img
id="mainImage"
src="../assets/upload/<?= $room['photo']; ?>"
>

<div class="thumbs">

<img
src="../assets/upload/<?= $room['photo']; ?>"
onclick="changeImage(this)"
>

<?php foreach($allPhotos as $foto){ ?>

<img
src="../assets/upload/<?= $foto['photo']; ?>"
onclick="changeImage(this)"
>

<?php } ?>

</div>

</div>

<form method="POST">
<label>Jenis Sewa</label>

<select
id="rent_type"
name="rent_type"
class="form-control"
onchange="hitungTotal()"
required>

<option value="harian">Harian</option>
<option value="Bulanan">Bulanan</option>

</select>

<label>Lama Sewa</label>

<input
type="number"
id="duration"
name="duration"
class="form-control"
min="1"
onkeyup="hitungTotal()"
onchange="hitungTotal()"
required>

<label>Check In</label>

<input
type="date"
name="check_in"
class="form-control"
required>

<label>Check Out</label>

<input
type="date"
name="check_out"
class="form-control"
required>

<br>

<h3 style="margin:20px 0;color:#2563eb;">
Total :
Rp <span id="totalHarga">0</span>
</h3>

<button
type="submit"
name="booking"
class="btn">

Konfirmasi Booking

</button>

</form>

</div>

</div>

<script>

function changeImage(img){

    document.getElementById("mainImage").src = img.src;

}

</script>

<script>

const hargaHarian = <?= $room['daily_price']; ?>;
const hargaBulanan = <?= $room['monthly_price']; ?>;

function hitungTotal(){

    let jenis = document.getElementById("rent_type").value;
    let lama = document.getElementById("duration").value;

    if(lama==""){
        lama=0;
    }

    let total=0;

    if(jenis=="harian"){
    total = hargaHarian * lama;
}else{
    total = hargaBulanan * lama;
}

    document.getElementById("totalHarga").innerHTML=
        total.toLocaleString('id-ID');

}

</script>

</body>

</html>