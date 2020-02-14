<?php
   session_start();
   include "pdo_connection.php";
   
   $code=isset($_POST['verificationCode'])?$_POST['verificationCode']:'';
   
   if(!empty($code)){
       $query="Select * from users where code= :code Limit 1";
       $stmt=$pdo->prepare($query);
       $stmt->bindValue(':code', $code);
       $stmt->execute();
       $results=$stmt->fetch();
       $res=$stmt->rowCount();
       if($res>0){
           if(!empty($results['maxtime']) && $results['maxtime']>date('Y-m-d',time())){
               updateUserVerified($code, $pdo);
           } else {
               header("Location: codeForm.php?field=code&message=This code has expired");
           }
       } else {
           header("Location: codeForm.php?field=code&message=This code is not valid");
       }
    } 
    else
        echo "Error with the server";
function updateUserVerified($code, $pdo) {
    $qry="Update users set status=1 where code= :code";
    $stmt=$pdo->prepare($qry);
    $stmt->bindValue(':code', $code);
    $stmt->execute();
    header("Location: loginForm.php");
}
?>