<?php
include_once "pdo_connection.php";

$message='';
$username=isset($_POST['username'])?$_POST['username']:'';
$email=isset($_POST['email'])?$_POST['email']:'';
$password=isset($_POST['password'])?$_POST['password']:'';
$cpassword=isset($_POST['cpassword'])?$_POST['cpassword']:'';

if(!empty($username) && !empty($email) && !empty($password) &&  !empty($cpassword)){
    $query="Select * from users where email= :email";
    $stmt=$pdo->prepare($query);
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    $no_of_rows=$stmt->rowCount();
    if($no_of_rows>0){
        echo "This email exists!";
    } 
    else { 
        include "PhpMail.php";
        $passwordHash=password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));
        $sql="Insert into users(username, email, password, confirmPassword) values (:username, :email, :password, :confirmPassword)";
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $passwordHash);
        $stmt->bindValue(':confirmPassword', $passwordHash);
        $result=$stmt->execute();
        $stmt=null;
    }
} 
 else {
    echo "Error";
}
?>