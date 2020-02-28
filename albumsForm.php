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
    <meta http-equiv="no-cache"> 
    <link href="css/image.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>
<body>
<div class="container  py-2">
<form  id="albums" class="album-form">
    <div class="row">
        <div class="col-md-5">
            <strong>Album :</strong>
            <input type="text" id="nameInput" name="album" class="form-control" placeholder="Album name">
            <p class="result"></p>
        </div>
        <div class="col-md-5">
           <br/>
           <button type="submit" class="btn btn-success" name="submitButton" id="createAlbum">Create album</button>
           <a class="btn btn-success" id="hidedAlbums" href="albumsForm.php?hidden=<?php echo 1;?>">Hided albums</a>
        </div>
        <div>
            <!--Begin my header.php include -->
            <br/>
               <?php include "header.php"; ?>
            <!-- End my header.php include -->
        </div>
        <div>
          <?php 
            //get album name, creates folder and instert into database
            $folderName=isset($_GET['album'])?$_GET['album']: '';
            $dir="images/$folderName";
            if(isset($_GET['submitButton'])){
                if(is_dir($dir)){ //control if this folder exists 
                    echo '<p>This album exists</>'; 
                } 
                else {
                    mkdir($dir); //creates the folder
                    insertAlbum($pdo, $folderName, $userId);
                }
            }
          ?>
        </div>
    </div>
</form>
</div>
<div class="album py-5" >
    <div class="container">
            <div class="row" id="showAlbums"></div>
    </div>
</div>
<div class="ui-widget" style="background-color:#FAF8F8;">
    <!-- dialog box for edditing album name -->
    <div class="dialogBoxes" id="editName" title="Edit Image" class="ui-icon ui-icon-circlesmall-close" >
      <fieldset>
        <input type="text" class="text ui-widget-content ui-corner-all" id="changeName"/>
        <button id="save">Save</button>
        </fieldset>
    </div>
    <div class="dialogBoxes" id="changeThumbnail" title="Choose photo" >
      <!-- displays thumbnails of album -->
       <fieldset></fieldset>
    </div>
<script>
$(document).ready(function(){
    sendData();
    $("#editName" ).dialog({
        autoOpen: false
    });
    $("#changeThumbnail").dialog({
        autoOpen: false,
        width: '650px'
    })
    $('#createAlbum').click(function(){
        var album=$('input[name="album"]').val();
        if(album==''){
            $('.result').html("Please fill the name of the album");
        } else  {
           $.ajax({
               url:"albumsForm.php",
               method:'GET',
               data:{album:album},
               success: function(){
                window.location.reload();
               }
           });
        }     
    });
    $('body').on('click', 'button[name="delete"]', function(e){
        var n =(e.target.id).lastIndexOf('-');
        var button=(e.target.id).substring(n+1);
        var deletet=$(this).val();
        if(!confirm("Are you sure?")){
            e.preventDefault();
            window.location.reload();
        }
        else {
            $.ajax({
                url: "editAlbum.php",
                method:'POST',
                data:{'folderId':button, 'delete':deletet},
                success: function(){
                    window.location.reload();
                }
            }); 
        }
    });
    $('body').on('click', 'button[name="hide"]', function(e){
        var n =(e.target.id).lastIndexOf('-');
        var button=(e.target.id).substring(n+1);
        var hide=$(this).val();
        var hidden=window.location.search.split('=')[1];
        $.ajax({
            url: "editAlbum.php",
            method:'POST',
            data:{'folderId':button, 'hide':hide, 'hidden': hidden},
            success: function(result){
                window.location.reload();
            }
        });
    });
    $('body').on('click', 'button[name="edit"]', function(e){
        var n =(e.target.id).lastIndexOf('-');
        var button=(e.target.id).substring(n+1);
        $("#editName").dialog('open');
        editName(button);
        
    });
    $('body').on('click', 'button[name="change"]', function(e){
        var n =(e.target.id).lastIndexOf('-');
        var button=(e.target.id).substring(n+1);
        var change=$(this).val();
        $("#changeThumbnail").dialog('open');
        $.ajax({
           url:"editAlbum.php",
           method:"POST",
           data: {'folderId':button, 'change':change},
           success: function(result){
                $("#changeThumbnail").html(result);
           }
        });
    });
    $('body').on('click', '.aaf', function(){
        var path=$(this).attr('value');
        var folderId=$(this).attr('id');
        $.ajax({
            url:'editAlbum.php',
            method:'POST',
            data: {path, folderId},
            success:function(){
                window.location.reload();
            }
        });
    });
    $('#nameInput').keyup(function(){
        var albumName=$(this).val();
        if(albumName==''){
            sendData();
        } else {
            $('#showAlbums').html('');
            sendData(albumName);
        }
    });
});
function editName(button){
    $('#save').click(function(e){
        var name=$('#changeName').val();
        $.ajax({
            url:"editAlbum.php",
            method: 'POST',
            data:{'name':name, 'folderId': button},
            success: function(){
                window.location.reload();
            }
        });
    });
}
function sendData(albumName){
    var hidden=window.location.search.split('=')[1];
    $.ajax({
        url:'displayAlbum.php',
        method:"POST",
        data:{'albumName':albumName, 'hidden':hidden},
        success: function(result){
            $('#showAlbums').html(result);
        }
    });
}
</script>
</body>
</html>
<?php }
  else {
      header("location: loginForm.php"); //redirect to login form if it is not logged in 
  }
function insertAlbum($pdo, $folderName, $userId){ //insert albums into database
    $query="Insert into folders (folder_name, userId) values (?,?)"; 
    $stmt=$pdo->prepare($query);
    $stmt->execute(array($folderName,$userId));
}
?>