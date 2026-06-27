<?php

session_start();
require '../config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}

if(!isset($_GET['id'])){
    die("Booking tidak ditemukan.");
}

$id = $_GET['id'];

$stmt = $pdo->prepare("
DELETE FROM bookings
WHERE id=?
AND user_id=?
AND status='pending'
");

$stmt->execute([
    $id,
    $_SESSION['user_id']
]);

header("Location: riwayat.php");
exit;