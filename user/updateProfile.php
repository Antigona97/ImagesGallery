<?php session_start();
include ('../pdo_connection.php');
$userId=$_SESSION['userId'];
$username =isset($_POST['username'])?$_POST['username']:'';
$email =isset($_POST['email'])?$_POST['email']:'';
$currentPassword=isset($_POST['currentPassword'])?$_POST['currentPassword']:'';
$newPassword =isset($_POST['newPassword'])?$_POST['newPassword']:'';
$confirmPassword =isset($_POST['confirmPassword'])?$_POST['confirmPassword']:'';
var_dump($userId);
if (!empty($username) && !empty($email) && !empty($currentPassword) && !empty($newPassword) && !empty($confirmPassword)) {
    $hash=password_hash($newPassword, PASSWORD_BCRYPT, array("cost" => 12));
    $passwordHash=substr( $hash, 0, 60 );
    $qry="Select password from users where userId=:userId";
    $stmt=$pdo->prepare($qry);
    $stmt->bindValue(':userId', $userId);
    $stmt->execute();
  while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
    if(password_verify($currentPassword, $row['password'])){
        $query="UPDATE users SET username=:username, email=:email, password=:newPassword, confirmPassword=:confirmPassword where userId=:userId";
        $stmt=$pdo->prepare($query);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':newPassword', $passwordHash);
        $stmt->bindValue(':confirmPassword', $passwordHash);
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();
        header("Location: ../logout.php");
    }
    else header("Location: profile.php?field=currentPassword&message=Your current password is not correct");
  }
} else header("Location: profile.php");
?>