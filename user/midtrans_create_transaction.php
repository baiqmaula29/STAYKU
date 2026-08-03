<?php
session_start();
require '../config.php';
require '../midtrans_config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Silakan login terlebih dahulu.']);
    exit;
}

$booking_id = isset($_POST['booking_id']) ? (int) $_POST['booking_id'] : 0;

if (!$booking_id) {
    echo json_encode(['success' => false, 'message' => 'Booking tidak valid.']);
    exit;
}

$stmt = $pdo->prepare("
    SELECT bookings.*, users.fullname, users.email, users.phone
    FROM bookings
    JOIN users ON bookings.user_id = users.id
    WHERE bookings.id = ? AND bookings.user_id = ?
");
$stmt->execute([$booking_id, $_SESSION['user_id']]);
$booking = $stmt->fetch();

if (!$booking) {
    echo json_encode(['success' => false, 'message' => 'Booking tidak ditemukan.']);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM payments WHERE booking_id = ? ORDER BY id DESC LIMIT 1");
$stmt->execute([$booking_id]);
$existingPayment = $stmt->fetch();

if ($existingPayment && $existingPayment['status'] === 'paid') {
    echo json_encode(['success' => false, 'message' => 'Booking ini sudah dibayar.']);
    exit;
}

$order_id = 'STAYKU-' . $booking_id . '-' . time();

$customer = [
    'first_name' => $booking['fullname'],
    'email'      => $booking['email'],
    'phone'      => $booking['phone'] ?: '08123456789',
];

$item_details = [[
    'id'       => 'BOOKING-' . $booking_id,
    'price'    => (int) round($booking['total_price']),
    'quantity' => 1,
    'name'     => 'Sewa Kamar #' . $booking_id . ' (' . $booking['rent_type'] . ')',
]];

$result = midtransCreateSnapTransaction($order_id, $booking['total_price'], $customer, $item_details);

if (!$result['success']) {
    echo json_encode(['success' => false, 'message' => 'Gagal membuat transaksi: ' . $result['message']]);
    exit;
}

$insert = $pdo->prepare("
    INSERT INTO payments (booking_id, amount, order_id, snap_token, transaction_status, status)
    VALUES (?, ?, ?, ?, 'pending', 'pending')
");
$insert->execute([
    $booking_id,
    $booking['total_price'],
    $order_id,
    $result['token'],
]);

echo json_encode([
    'success' => true,
    'token'   => $result['token'],
]);