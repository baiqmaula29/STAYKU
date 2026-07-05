<?php
require '../config.php';

$id = $_GET['id'];

// Ambil data foto
$stmt = $pdo->prepare("SELECT * FROM room_photos WHERE id=?");
$stmt->execute([$id]);
$foto = $stmt->fetch();

if($foto){

    // Hapus file gambar
    $file = "../assets/upload/".$foto['photo'];

    if(file_exists($file)){
        unlink($file);
    }

    // Hapus dari database
    $hapus = $pdo->prepare("DELETE FROM room_photos WHERE id=?");
    $hapus->execute([$id]);

    // Kembali ke halaman sebelumnya
    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit;
}

echo "Foto tidak ditemukan.";