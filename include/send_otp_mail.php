<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

function sendOTP($to, $otp) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'secure.redunx.cloudstorage@gmail.com'; 
        $mail->Password = 'ensc anls sppn aaxk'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('secure.redunx.cloudstorage@gmail.com', 'Secure Cloud OTP');
        $mail->addAddress($to);
        $mail->Subject = 'Your Login OTP';
        $mail->Body = '
    <p>Your OTP for login is: <b>' . $otp . '</b></p>
    <p>This OTP is valid only for <b>5 minutes</b>.</p>
';


        $mail->isHTML(true);
        $mail->send();
    } catch (Exception $e) {
        die("Mailer Error: {$mail->ErrorInfo}");
    }
}
