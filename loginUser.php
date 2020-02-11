<?php
   include "pdo_connection.php";
   $username=isset($_POST['username']);
   $password=isset($_POST['password']);

if(isset($_POST['submit'])){

    if(!empty($username)&& !empty($password)){

       $passwordHash=password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));
       $query="Select userId from users where username= :username and password= :password";
       $stmt=$pdo->prepare($query);
       $stmt->bindValue(':username', $username);
       $stmt->bindValue(':password', $passwordHash);
       $stmt->execute();
       $no_row_count=$stmt->rowCount();
       if($no_row_count>0){
          header("Location: home.html");
       } else{
         alert("Please verify your username or password!");
       }
   }
} else {
    echo "hi";
}
?>