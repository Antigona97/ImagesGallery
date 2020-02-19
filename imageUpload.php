<?php session_start();
include "pdo_connection.php"; 
$folderName= $_SESSION['folderName'];
$folderId=$_SESSION['folderId'];
$filename=isset($_FILES["image"]["name"])?$_FILES["image"]["name"]: '';
$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt');
$location = "images/$folderName/".$filename;
$dir="images/$folderName";
if(isset($_POST["upload"])){
   if(is_dir($dir)){
     uploadImage($pdo, $valid_extensions, $folderId, $filename, $location);
     makeThumbnail($pdo, $location, $filename);
   } else {
     mkdir($dir);
     uploadImage($pdo, $valid_extensions, $folderId, $filename, $location);
     makeThumbnail($pdo, $location, $filename);
    }
}
function uploadImage($pdo, $valid_extensions, $folderId, $filename, $location){
   $query="INSERT INTO images(path, filename, folderId) VALUES (?, ?, ?) ";
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
      $stmt->execute(array($location, $filename, $folderId));
     }
   } else {
   echo 'invalid';
   }
}
function makeThumbnail($pdo,$location, $filename){
  $destination="images/thumbnail/$filename";
  $desired_width="200";
  $source_image=imagecreatefromjpeg($location);
  $width = imagesx($source_image);
  $height = imagesy($source_image);
  $desired_height = floor($height * ($desired_width / $width));
  $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
  imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
  imagejpeg($virtual_image, $destination);
  $query="INSERT INTO thumbnails(thumbnailName, thumbnailPath) VALUES (:thumbnailName, :thumbnailPath) ";
   $stmt=$pdo->prepare($query);
   $stmt->bindValue(':thumbnailName', $filename);
   $stmt->bindValue(':thumbnailPath', $destination);
   $stmt->execute();
}
?>