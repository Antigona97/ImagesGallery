<?php
  session_start();
  include_once "pdo_connection.php";

  $username=isset($_POST['username'])?$_POST['username']:'';
  $password=isset($_POST['password'])?$_POST['password']:'';
  if(!empty($username)&& !empty($password)){
      //returns password and status of the user logged in
        $query="Select * from users where username=? LIMIT 1";
        $stmt=$pdo->prepare($query);
        $stmt->execute(array($username));
        $user=$stmt->fetch();
        $no_of_rows=$stmt->rowCount();
      //controls if exists a user with that username and if the account is verified
        if($no_of_rows>0){
          $email=$user['email'];
          if(!empty($user['password']) && password_verify($password,$user['password'])){
            $_SESSION['userId']=$user['userId'];
            if($user['status']==1){
              header("Location: albumsForm.php?hidden=0");
            } else {
              header("Location: loginForm.php?field=verify&message=Account is not verified&email=$email");
            }
          } else {
            header("Location: loginForm.php?field=password&message=Password is not valid");
          }
        } else{
          header("Location: loginForm.php?field=username&message=This username does not exists");
        } $stmt=null;
  } else
        echo "Please enter username and password!";
?>