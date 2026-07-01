<?php

session_start();
require '../config.php';

if(!isset($_GET['id']) || !isset($_GET['booking'])){
    die("Data tidak lengkap.");
}

$payment_id = $_GET['id'];
$booking_id = $_GET['booking'];

// Status pembayaran menjadi paid
$stmt = $pdo->prepare("
UPDATE payments
SET status='paid'
WHERE id=?
");
$stmt->execute([$payment_id]);

// Status booking menjadi Lunas
$stmt = $pdo->prepare("
UPDATE bookings
SET status='Lunas'
WHERE id=?
");
$stmt->execute([$booking_id]);

// Ambil id kamar dari booking
$stmt = $pdo->prepare("
SELECT room_id
FROM bookings
WHERE id=?
");
$stmt->execute([$booking_id]);

$data = $stmt->fetch();

// Status kamar menjadi occupied
$stmt = $pdo->prepare("
UPDATE rooms
SET status='occupied'
WHERE id=?
");
$stmt->execute([$data['room_id']]);

header("Location: pembayaran.php");
exit;

?>