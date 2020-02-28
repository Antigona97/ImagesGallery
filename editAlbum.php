<?php
   include "pdo_connection.php";
   
   if(isset($_POST['name'])){ //updates name of the album
      $folderName=$_POST['name'];
      $folderId=$_POST['folderId'];
      $query="Update folders set folder_name=? where folderId=?";
      $stmt=$pdo->prepare($query);
      $stmt->execute(array($folderName,$folderId));
   }
   if(isset($_POST['delete']) && isset($_POST['folderId'])){ //controls if the delete button is clicked and deletes album
      $folderId=$_POST['folderId'];
      $query="Select folder_name from folders where folderId=:folderId";
      $stmt = $pdo->prepare($query);
      $stmt->bindValue(':folderId', $folderId);
      $stmt->execute();
      while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
         $folder_name=$row['folder_name'];
         $files = glob("images/$folder_name/*.*"); //gets all the files into this folder
         foreach ($files as $file) {
            unlink($file); //deletes files into this folder
         }
         rmdir("images/$folder_name"); //removes folder
      } $stmt=null;
      $query2="Delete from images where folderId=:folderId;
               Delete from thumbnails where folderId=:folderId;
               Delete from folders where folderId=:folderId";
      $stmt=$pdo->prepare($query2);
      $stmt->bindValue(':folderId', $folderId);
      $stmt->execute();
    
   };
   if(isset($_POST['hide']) && isset($_POST['folderId'])){ //if the hide button is clicked updates column hide
      $hidden = (isset($_POST['hidden']) && (int)$_POST['hidden'] === 1)?0:1;
      $folderId=$_POST['folderId'];
      $query="Update folders set hide=? where folderId=?";
      $stmt = $pdo->prepare($query);
      $stmt->execute(array($hidden,$folderId));
   }
   if(isset($_POST['change']) && isset($_POST['folderId'])){ //displays into dialog box thumbnail images
      $folderId=$_POST['folderId'];
      $query="Select * from thumbnails where folderId=?";
      $stmt = $pdo->prepare($query);
      $stmt->execute(array($folderId));
      while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
         $path=$row['thumbnailPath'];
         $name=$row['thumbnailName'];
         echo "<button class='aaf' id='$folderId' value='$name'><img src='$path' alt='$name'/><br/></button>";
      }
   }
   if(isset($_POST['path']) && isset($_POST['folderId'])){ //updates wallpaper of the clicked folder
      $path=$_POST['path'];
      $folderId=$_POST['folderId'];
      $query="Update folders set wallpaper=? where folderId=?";
      $stmt = $pdo->prepare($query);
      $stmt->execute(array($path,$folderId));
   }
?>