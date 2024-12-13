<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Generate a 6-digit OTP
    $otp = rand(100000, 999999);
    $otp_created_at = date('Y-m-d H:i:s');

    // Store OTP in the database
    $stmt = $pdo->prepare("UPDATE users SET otp = ?, otp_created_at = ? WHERE email = ?");
    $stmt->execute([$otp, $otp_created_at, $email]);

    if ($stmt->rowCount() > 0) {
        // Simulate sending OTP (you can replace this with actual email/SMS code)
        $_SESSION['email'] = $email;
        echo "OTP sent to your email (or simulate via console/log for testing): $otp";
    } else {
        echo "Email not registered.";
    }
}
?>