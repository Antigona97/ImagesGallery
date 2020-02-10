<?php
include_once "pdo_connection.php";

$username=isset($_POST['username'])?$_POST['username']:'';
$email=isset($_POST['email'])?$_POST['email']:'';
$password=isset($_POST['password'])?$_POST['password']:'';
$cpassword=isset($_POST['cpassword'])?$_POST['cpassword']:'';
if(!empty($username)&& !empty($email)&& !empty($password) &&  !empty($cpassword)) {
    $passwordHash=password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));
    $sql="Insert into users(username, email, password, confirmPassword) values (:username, :email, :password, :confirmPassword)";
    $stmt=$pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $passwordHash);
    $stmt->bindValue(':confirmPassword', $passwordHash);
    $result=$stmt->execute();
    if($result){
        //What you do here is up to you!
        echo 'Thank you for registering with our website.';
    } 
    $stmt=null;
}
else {
    echo "error";
}
?>