<?php
   session_start();
   include "pdo_connection.php";
   
   $code=isset($_POST['verificationCode'])?$_POST['verificationCode']:'';
   
   if(!empty($code)){ //gets code from input and controls in db if exists
       $query="Select * from users where code=? Limit 1";
       $stmt=$pdo->prepare($query);
       $stmt->execute(array($code));
       $results=$stmt->fetch();
       $res=$stmt->rowCount();
       if($res>0){
           if(!empty($results['maxtime']) && $results['maxtime']>date('Y-m-d',time())){ //controls if the code has not expired
               updateUserVerified($code, $pdo); //updates status and redirects to login
           } else {
               header("Location: codeForm.php?field=code&message=This code has expired");
           }
       } else {
           header("Location: codeForm.php?field=code&message=This code is not valid");
       }
    } 
    else
        echo "Error with the server";
function updateUserVerified($code, $pdo) { //updates status when the code is valid
    $qry="Update users set status=1 where code=?";
    $stmt=$pdo->prepare($qry);
    $stmt->execute(array($code));
    header("Location: loginForm.php");
}
?>