<?php
session_start();
include "pdo_connection.php";
if(isset($_SESSION['userId'])) {
    $userId=$_SESSION['userId'];
?> 
<div>
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
        <?php 
            $folderName=isset($_POST['album'])?$_POST['album']: '';
            $_SESSION['folderName']=$folderName;
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
    </form>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="css/image.css" rel="stylesheet" type="text/css" media="all" />
<script>
    $('#createAlbum').click(function(){
        var album=$('input[name="album"]').val();
        if(album==''){
            $('.result').html("Please fill the name of the album");
        } else  {
            $('#albums').submit();
        }
        
    });
</script>
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
?>