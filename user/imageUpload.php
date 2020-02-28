<?php session_start();
include ('../pdo_connection.php'); 
$folderName= $_SESSION['folderName'];
$folderId=$_SESSION['folderId'];
$filename=isset($_FILES["image"]["name"])?$_FILES["image"]["name"]: ''; //gets all files from form
$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt'); //valid extensions for files 
$location = "images/$folderName/$filename";
$dir="images/$folderName";
if(isset($_POST["upload"])){ //if the upload button is clicked
   if(is_dir($dir)){ //controls if this directory exists
     uploadImage($pdo, $valid_extensions, $folderId, $filename, $location);
     makeThumbnail($pdo, $location, $filename, $folderId);
   } else {
     mkdir($dir); //create a new directory
     uploadImage($pdo, $valid_extensions, $folderId, $filename, $location);
     makeThumbnail($pdo, $location, $filename, $folderId);
    } header("Location: home.php?folder_name=$folderName&folderId=$folderId"); //redirects to home.php
}
if(isset($_POST["delete"]) && isset($_POST['imageId'])){ //controls if the delete button is clicked
  $imageId=$_POST['imageId'];
  $query="Select filename from images where imageId=?;";
  $stmt = $pdo->prepare($query);
  $stmt->execute(array($imageId));
  while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
    $filename=$row['filename'];
    $imagePath="images/$folderName/$filename";
    $thumbnailPath="images/thumbnail/$filename";
    if(file_exists($imagePath) || file_exists($thumbnailPath)){
      unlink($imagePath); //removes current file from folder
      unlink($thumbnailPath); //removes current file from thumbnail folder
    }
    $qry1="Delete from images where imageId=?;";
    $st=$pdo->prepare($qry1);
    $st->execute(array($imageId));
    $st=null;
    $qry2="Delete from thumbnails where folderId=? and thumbnailPath=?";
    $st = $pdo->prepare($qry2);
    $st->execute(array($folderId, $thumbnailPath));
    $st=null;
  } 
  $stmt=null;
}
if(isset($_POST['hide']) && isset($_POST['imageId'])){  
  $hidden = (isset($_POST['hidden']) && (int)$_POST['hidden'] === 1)?0:1; //gets hidden parameter value from url
  $imageId=$_POST['imageId'];
  $query="Update images set hide=? where imageId=?";
  $stmt = $pdo->prepare($query);
  $stmt->execute(array($hidden,$imageId));
}
function uploadImage($pdo, $valid_extensions, $folderId, $filename, $location){ //insert image to database and in the specified folder
   $query="INSERT INTO images(path, filename, folderId) VALUES (?, ?, ?) ";
   $stmt=$pdo->prepare($query);
   $tmp=$_FILES["image"] ["tmp_name"];
   // get uploaded file's extension
   $temp = (explode(".", $filename));
   $ext=end($temp);
   // check's valid format
    if(in_array($ext, $valid_extensions)) 
    { 
      if(move_uploaded_file($tmp,$location))  //upload file to directory
      { 
          //insert form data in the database
          $stmt->execute(array($location, $filename, $folderId));
      }
    } else {
        echo 'invalid';
    }
}
function makeThumbnail($pdo,$location, $filename, $folderId){ //creates thumbnail image 
    $destination="images/thumbnail/$filename";
    $desired_width="200"; 
    $source_image=imagecreatefromjpeg($location); //creates a new thumbnail from file
    $width = imagesx($source_image); //width of thumbnail
    $height = imagesy($source_image); //height of thumbnail
    $desired_height = floor($height * ($desired_width / $width)); //rounds the height to integer
    $virtual_image = imagecreatetruecolor($desired_width, $desired_height); //create a new image with true color
    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height); //resize thumbnail image
    imagejpeg($virtual_image, $destination);  //creates jpeg image to desired folder
    $query="INSERT INTO thumbnails(thumbnailName, thumbnailPath, folderId) VALUES (?, ?, ?) ";
    $stmt=$pdo->prepare($query);
    $stmt->execute(array($filename,$destination,$folderId));
    $stmt=null;
}
?>