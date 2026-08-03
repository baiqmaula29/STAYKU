<?php
/**
 * ==========================================================
 *  MIDTRANS NOTIFICATION HANDLER (WEBHOOK)
 * ==========================================================
 * Didaftarkan di Midtrans Dashboard > Settings > Configuration
 * > Payment Notification URL, contoh:
 *   https://domainkamu.com/stayku/midtrans_notification.php
 * ==========================================================
 */

require 'config.php';
require 'midtrans_config.php';

header('Content-Type: application/json');

$rawInput = file_get_contents('php://input');
$notif = json_decode($rawInput, true);

if (!$notif || !isset($notif['order_id'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Payload tidak valid']);
    exit;
}

$order_id           = $notif['order_id'];
$status_code        = $notif['status_code'] ?? '';
$gross_amount       = $notif['gross_amount'] ?? '';
$signature_key      = $notif['signature_key'] ?? '';
$transaction_status = $notif['transaction_status'] ?? '';
$fraud_status       = $notif['fraud_status'] ?? null;
$payment_type       = $notif['payment_type'] ?? null;

if (!midtransVerifySignature($order_id, $status_code, $gross_amount, $signature_key)) {
    http_response_code(403);
    echo json_encode(['message' => 'Signature tidak valid']);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM payments WHERE order_id = ?");
$stmt->execute([$order_id]);
$payment = $stmt->fetch();

if (!$payment) {
    http_response_code(404);
    echo json_encode(['message' => 'Payment record tidak ditemukan untuk order_id ini']);
    exit;
}

$booking_id = $payment['booking_id'];

$paymentStatus = $payment['status'];
$bookingStatus = null;

if ($transaction_status == 'capture') {
    if ($fraud_status == 'accept') {
        $paymentStatus = 'paid';
        $bookingStatus = 'Lunas';
    }
} elseif ($transaction_status == 'settlement') {
    $paymentStatus = 'paid';
    $bookingStatus = 'Lunas';
} elseif ($transaction_status == 'pending') {
    $paymentStatus = 'pending';
    $bookingStatus = 'Menunggu Verifikasi';
} elseif (in_array($transaction_status, ['deny', 'expire', 'cancel'])) {
    $paymentStatus = 'rejected';
    $bookingStatus = 'cancelled';
}

$pdo->prepare("
    UPDATE payments
    SET status = ?, transaction_status = ?, payment_type = ?
    WHERE order_id = ?
")->execute([$paymentStatus, $transaction_status, $payment_type, $order_id]);

if ($bookingStatus) {
    $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?")
        ->execute([$bookingStatus, $booking_id]);

    if ($bookingStatus === 'Lunas') {
        $stmt = $pdo->prepare("SELECT room_id FROM bookings WHERE id = ?");
        $stmt->execute([$booking_id]);
        $room = $stmt->fetch();

        if ($room) {
            $pdo->prepare("UPDATE rooms SET status = 'occupied' WHERE id = ?")
                ->execute([$room['room_id']]);
        }
    }
}

http_response_code(200);
echo json_encode(['message' => 'OK']);