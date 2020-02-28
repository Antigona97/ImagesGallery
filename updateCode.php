<?php
include "pdo_connection.php";

if(isset($_POST['email']) && $_POST['email']!==''){
    $email=$_POST['email'];
    $maxtime=date('Y-m-d',(time()+24*3600)); //time when code expires
    echo $maxtime;
    $code=substr(md5(mt_rand()), 0, 4);  //generate code
    echo $code;
    $query="Update users set code=?, maxtime=? where email=?";
    $stmt=$pdo->prepare($query);
    $result=$stmt->execute(array($code,$maxtime,$email));
    if($result){
        include "verificationCode.php"; //sends verification code
    } else echo "Happened an error with sending code";
}
?>