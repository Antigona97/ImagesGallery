<?php
session_start();
  include "pdo_connection.php";
$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt');
$folderName=$_SESSION['folderName'];
$filename=isset($_FILES["image"]["name"])?$_FILES["image"]["name"]: '';
$location = "images/$folderName/".$filename;
$dir="images/$folderName";
if(isset($_POST["upload"])){
   if(is_dir($dir)){
     uploadImage($pdo, $valid_extensions, $folderName, $filename, $location);
   } else {
     mkdir($dir);
     uploadImage($pdo, $valid_extensions, $folderName, $filename, $location);
   }
} else {
   echo "Errorrrr";
}
function uploadImage($pdo, $valid_extensions, $folderName, $filename, $location){
   $query="INSERT INTO images(path, filename) VALUES (?, ?) ";
   $stmt=$pdo->prepare($query);
   $tmp=$_FILES["image"] ["tmp_name"];
   // get uploaded file's extension
   $temp = (explode(".", $filename));
   $ext=end($temp);
   // check's valid format
   if(in_array($ext, $valid_extensions)) 
   { 
     if(move_uploaded_file($tmp,$location)) 
     { 
      //insert form data in the database
      $stmt->execute(array($location, $filename));
      echo "<img src='$location' class='center'; />";
     }
   } else {
   echo 'invalid';
   }
}
/*function getImage($pdo) {
   $qry="Select path from images where";
   $stmt=$pdo->prepare($qry);
   $stmt->execute();
   while( $arr=$stmt->fetch()){
      if(!$arr) exit('No images in the folder');
      $path=$arr['path']; 
      echo "<img src='$path' class='center' />";
   }
   $stmt = null;
}*/
?>