<?php
session_start();
include "pdo_connection.php";
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require_once 'PHPMailer-master/src/Exception.php';

$username=isset($_POST['username'])?$_POST['username']:'';
$email=isset($_POST['email'])?$_POST['email']:'';
$password=isset($_POST['password'])?$_POST['password']:'';
$cpassword=isset($_POST['cpassword'])?$_POST['cpassword']:'';

$hash=password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));
$passwordHash=substr( $hash, 0, 60 );
$_SESSION['username']=$username;
$expires=(time()+24*3600); //time when expires verification code 24 hours

if(!empty($username) && !empty($email) && !empty($password) &&  !empty($cpassword)){
    $query_e="Select * from users where email= :email";
    $stmt=$pdo->prepare($query_e);
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    $res_e=$stmt->rowCount();
    $query_u="Select * from users where username= :username";
    $stmt_u=$pdo->prepare($query_u);
    $stmt_u->bindValue(':username', $username);
    $stmt_u->execute();
    $res_u=$stmt_u->rowCount();
    if($res_e>0){
        header("Location: registerForm.php?field=email&message=This email exists");
    } else 
    if($res_u>0){
        header("Location: registerForm.php?field=username&message=This username is already taken");
    }
    else { 
        //register user in database
        registerUser($username, $email, $passwordHash, $expires, $pdo);
    }
} 
 else {
     echo "Error";
}

function sendVerificationEmail ($email, $code){
    $mail=new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username="email";
    $mail->Password="password";
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587; 
    $mail->setFrom('antigonakoka@gmail.com');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Body="Please verify your account with the code ".$code;
    $mail->send();
}
function registerUser($username, $email, $passwordHash, $expires, $pdo) {
    $code=substr(md5(mt_rand()), 0, 4);
    $sql="Insert into users(username, email, password, confirmPassword, code, maxtime) values (:username, :email, :password, :confirmPassword, :code, :maxtime)";
    $stmt=$pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $passwordHash);
    $stmt->bindValue(':confirmPassword', $passwordHash);
    $stmt->bindValue(':code', $code);
    $stmt->bindValue(':maxtime', date('Y-m-d',$expires));
    $result=$stmt->execute();
    if ($result) {
        sendVerificationEmail($email, $code);
        header("Location: codeForm.php");

    } else {
        $_SESSION['error_msg'] = "Database error: Could not register user";
    }
}
?>