<?php
include "pdo_connection.php";

$username=isset($_POST['username'])?$_POST['username']:'';
$email=isset($_POST['email'])?$_POST['email']:'';
$password=isset($_POST['password'])?$_POST['password']:'';
$cpassword=isset($_POST['cpassword'])?$_POST['cpassword']:'';

$hash=password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));
$passwordHash=substr( $hash, 0, 60 );
$expires=(time()+24*3600); //time when expires verification code 24 hours

if(!empty($username) && !empty($email) && !empty($password) &&  !empty($cpassword)){
    $query_e="Select * from users where email=?";
    $stmt=$pdo->prepare($query_e);
    $stmt->execute(array($email));
    $res_e=$stmt->rowCount();
    $query_u="Select * from users where username=?";
    $stmt_u=$pdo->prepare($query_u);
    $stmt_u->execute(array($username));
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
function registerUser($username, $email, $passwordHash, $expires, $pdo) {
    $code=substr(md5(mt_rand()), 0, 4);
    $maxtime=date('Y-m-d',$expires);
    $sql="Insert into users(username, email, password, confirmPassword, code, maxtime) values (?,?,?,?,?,?)";
    $stmt=$pdo->prepare($sql);
    $result=$stmt->execute(array($username,$email,$passwordHash,$passwordHash,$code,$maxtime));
    if ($result) {
        include "verificationCode.php";
        header("Location: codeForm.php");

    } else {
        $_SESSION['error_msg'] = "Database error: Could not register user";
    }
}
?>