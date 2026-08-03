<?php
/**
 * ==========================================================
 *  KONFIGURASI MIDTRANS - StayKu Mandalika
 * ==========================================================
 * Ambil Server Key & Client Key dari:
 * https://dashboard.midtrans.com/settings/config_info
 * (pakai akun SANDBOX dulu untuk testing, baru pindah ke
 *  Production kalau sudah siap live)
 * ==========================================================
 */

// TODO: ganti dengan key asli dari dashboard Midtrans kamu
define('MIDTRANS_SERVER_KEY', 'YOUR_SERVER_KEY');
define('MIDTRANS_CLIENT_KEY', 'YOUR_CLIENT_KEY');

// false = Sandbox (testing), true = Production (asli/live)
define('MIDTRANS_IS_PRODUCTION', false);

define('MIDTRANS_SNAP_BASE_URL', MIDTRANS_IS_PRODUCTION
    ? 'https://app.midtrans.com/snap/v1/transactions'
    : 'https://app.sandbox.midtrans.com/snap/v1/transactions'
);

/**
 * Membuat transaksi Snap ke Midtrans dan mengembalikan snap_token.
 */
function midtransCreateSnapTransaction($order_id, $gross_amount, $customer, $item_details = []) {

    $payload = [
        'transaction_details' => [
            'order_id'     => $order_id,
            'gross_amount' => (int) round($gross_amount),
        ],
        'customer_details' => $customer,
    ];

    if (!empty($item_details)) {
        $payload['item_details'] = $item_details;
    }

    $ch = curl_init(MIDTRANS_SNAP_BASE_URL);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => json_encode($payload),
        CURLOPT_HTTPHEADER     => [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode(MIDTRANS_SERVER_KEY . ':'),
        ],
        CURLOPT_SSL_VERIFYPEER => true,
    ]);

    $response   = curl_exec($ch);
    $httpCode   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError  = curl_error($ch);
    curl_close($ch);

    if ($curlError) {
        return ['success' => false, 'token' => null, 'redirect_url' => null, 'message' => 'cURL error: ' . $curlError];
    }

    $data = json_decode($response, true);

    if ($httpCode == 201 && isset($data['token'])) {
        return [
            'success'      => true,
            'token'        => $data['token'],
            'redirect_url' => $data['redirect_url'] ?? null,
            'message'      => 'OK',
        ];
    }

    return [
        'success'      => false,
        'token'        => null,
        'redirect_url' => null,
        'message'      => $data['error_messages'][0] ?? ('HTTP ' . $httpCode),
    ];
}

/**
 * Verifikasi signature_key yang dikirim Midtrans di notification webhook.
 */
function midtransVerifySignature($order_id, $status_code, $gross_amount, $signature_key) {
    $expected = hash('sha512', $order_id . $status_code . $gross_amount . MIDTRANS_SERVER_KEY);
    return hash_equals($expected, $signature_key);
}