<?php session_start();
    include ('../pdo_connection.php');
    $userId=$_SESSION['userId'];

    $albumName=isset($_POST['albumName'])?$_POST['albumName']:'';
    //gets hidden value from url and returns album 
    $hidden = (isset($_POST['hidden']))?(int)$_POST['hidden'] :0;
    //displays albums from database
    $query ="Select wallpaper, folder_name, folderId from folders where userId=? and hide=? and folder_name like ? Group by folder_name";
    $stmt=$pdo->prepare($query);
    $stmt->execute(array($userId,$hidden,"%$albumName%"));
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        if(!($row)) exit("You don't have any albums");
        else { 
        $file=$row['wallpaper'];
        $folder=$row["folder_name"];
        $folderId=$row['folderId'];
        echo '<div class="col-md-4">
                <div class="card">
                  <a id="link" href="carouselForm.php?folder_name='.$folder.'&folderId='.$folderId.'&hidden=0"> 
                  <img class="card-img-top" src="images/thumbnail/'.$file.'" alt='.$folder.' border-radius: 5px 5px 0 0; style="height: 200px; width: 100%" data-holder-rendered="true">
                  </a>
                <div class="card-body">'.$folder.'
                   <button name="change" class="ui-icon ui-icon-image" id="changePhoto-'.$folderId.'"></button>
                   <button name="edit" class="ui-icon ui-icon-pencil" id="editAlbum-'.$folderId.'"></button>
                   <button name="hide" class="ui-icon  ui-icon-folder-collapsed" id="hideAlbum-'.$folderId.'"></button>
                   <button name="delete" class="ui-icon ui-icon-trash" id="deleteAlbum-'.$folderId.'"></button>
                </div> 
                </div> <br/>
            </div> ';
        }
    }    
?>