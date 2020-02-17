<?php
session_start();
include "pdo_connection.php";
if(isset($_SESSION['userId'])) {
    $userId=$_SESSION['userId'];
?> 
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="css/image.css" rel="stylesheet" type="text/css" media="all" />
    <link href="bootstrap-4.4.1/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
<div class="container  py-2 bg-light">
<form method="POST" enctype="multipart/form-data" id="albums" class="album-form">
    <div class="row">
        <div class="col-md-5">
            <strong>Album :</strong>
            <input type="text" name="album" class="form-control" placeholder="Album name">
            <p class="result"></p>
        </div>
        <div class="col-md-2">
           <br/>
           <button type="submit" class="btn btn-success" name="submitButton" id="createAlbum">Create new album</button>
        </div>
    </div>
</form>
</div>
<div class="album py-5" >
    <div class="container bg-light">
       <div class="row">
          <?php returnAlbums($pdo, $userId); ?>
       </div>
    </div>
</div>
        <?php 
            $folderName=isset($_POST['album'])?$_POST['album']: '';
            $dir="images/$folderName";
            if(isset($_POST['submitButton'])){
                if(is_dir($dir)){ 
                    echo '<p>This album exists</p>'; 
                } 
                else {
                    mkdir($dir);
                    insertAlbum($pdo, $folderName, $userId);
                }
            }

        ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
    $('#createAlbum').click(function(){
        var album=$('input[name="album"]').val();
        if(album==''){
            $('.result').html("Please fill the name of the album");
        } else  {
            $('#albums').submit();
        }
        
    });
    $('document').ready(function(){
    })
</script>
</body>
</html>
<?php }
  else {
      header("location: loginForm.php");
  }
function insertAlbum($pdo, $folderName, $userId){
    $query="Insert into folders (folder_name, userId) values (:folder_name, :userId)"; 
    $stmt=$pdo->prepare($query);
    $stmt->bindValue(':folder_name', $folderName);
    $stmt->bindValue(':userId', $userId);
    $stmt->execute();
}
function returnAlbums($pdo, $userId){
    $query ="Select f.folder_name, f.folderId, i.path from folders f left join images i on f.folderId=i.folderId where userId=:userId Group by f.folder_name";
    $stmt=$pdo->prepare($query);
    $stmt->bindValue(':userId', $userId);
    $stmt->execute();
    while($row=$stmt->fetch()){
       if(!($row)) exit("You don't have any albums");
       else {
        $folder=$row["folder_name"];
        $path=$row['path'];
        $_SESSION['folderId']=$row["folderId"];
        echo '<div class="col-md-4">
                <div class="card">
                  <a href="home.php?folder_name='.$folder.'">
                  <img class="card-img-top" src="'.$path.'" alt='.$folder.' border-radius: 5px 5px 0 0; style="height: 200px; width: 100%" data-holder-rendered="true">
                  </a>
                <div class="card-body">'.$folder.'</div> 
                </div> <br/>
            </div> ';
       }
    }
}
?>