<?php 
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require_once 'PHPMailer-master/src/Exception.php';
//function that sends verification code
    $mail=new PHPMailer\PHPMailer\PHPMailer(); 
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username="email";
    $mail->Password="password";
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587; 
    $mail->setFrom('email');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Body="Please verify your account with the code ".$code;
    $mail->send();
?>