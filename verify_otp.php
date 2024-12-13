<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_SESSION['email'];
    $otp = $_POST['otp'];

    // Fetch the OTP and creation time from the database
    $stmt = $pdo->prepare("SELECT otp, otp_created_at FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $stored_otp = $user['otp'];
        $otp_created_at = $user['otp_created_at'];
        $current_time = date('Y-m-d H:i:s');

        // Validate OTP and check expiry (5 minutes)
        if ($stored_otp == $otp && (strtotime($current_time) - strtotime($otp_created_at)) <= 300) {
            echo "OTP verified successfully. Welcome!";
        } else {
            echo "Invalid or expired OTP.";
        }
    } else {
        echo "User not found.";
    }
}
?>