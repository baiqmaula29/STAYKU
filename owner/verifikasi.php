<?php

session_start();
require '../config.php';

if(!isset($_GET['id']) || !isset($_GET['booking'])){
    die("Data tidak lengkap");
}

$payment_id = $_GET['id'];
$booking_id = $_GET['booking'];

// Update pembayaran
$pdo->prepare("
UPDATE payments
SET status='paid'
WHERE id=?
")->execute([$payment_id]);

// Update booking
$pdo->prepare("
UPDATE bookings
SET status='Lunas'
WHERE id=?
")->execute([$booking_id]);

header("Location: boking.php");
exit;