<?php
    
    require 'PHPMailer-master/src/PHPMailer.php';
    require 'PHPMailer-master/src/SMTP.php';
    require_once 'PHPMailer-master/src/Exception.php';
  
        $mail=new PHPMailer\PHPMailer\PHPMailer();
        $code=substr(md5(mt_rand()), 0, 15);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username="antigonakoka@gmail.com";
        $mail->Password="";
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587; 
        $mail->setFrom('antigonakoka@gmail.com');
        $mail->addAddress('dikaelson@gmail.com');
        $mail->isHTML(true);
        $mail->Body="Please click the link below".$code;
        $mail->send();
?>