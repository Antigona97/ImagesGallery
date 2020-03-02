<?php session_start();
include ('slider.php');
if(isset($_SESSION['userId'])){
    
    $folderName=(isset($_GET['folder_name']))?$_GET['folder_name']:'';
    $folderId=(isset($_GET['folderId']))?$_GET['folderId']:'';

    $userId=$_SESSION['userId'];
    $_SESSION['folderName']=$folderName;
    $_SESSION['folderId']=$folderId;
?>
<!Doctype html>
<html>
<head>
    <link href="../css/image.css" rel="stylesheet" type="text/css" media="all" />
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>
<body>
<div class="container">
    <form id="form" method="POST" action="imageUpload.php" enctype="multipart/form-data" class="album-form"> 
        <div class="row">
            <div class="col-md-5">
                <strong>Image:</strong> </br>
                <input type="file" type="text" name="image" class="form-control">
            </div>
            <div class="col-md-5">
                <br/>
                <button type="submit" name="upload" id="submitButton" class="btn btn-success">Upload</button>
            </div>
            <div>
               <!--Begin my header.php include -->
               <br/>
                 <?php include ('../header.php'); ?>
               <!-- End my header.php include -->
            </div>
        </div>
    <br/>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <?php echo $slider_html; ?> <!-- displays images into carousel -->
          <ol class="carousel-indicators"><?php echo $button_html; ?></ol> <!-- controls carousel-indicators -->
        </div> 
        <br/>
        <ul id="thumbnail" class="thumbnails-carousel clearfix">
            <?php echo $thumb_html; ?> <!-- displays thumbnails into carousel -->
        </ul>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" style='height:500px' role="button" data-slide="prev">
           <span class="carousel-control-prev-icon" aria-hidden="true"></span>
           <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" style='height:500px' role="button" data-slide="next">
           <span class="carousel-control-next-icon" aria-hidden="true"></span>
           <span class="sr-only">Next</span>
        </a>
    </div> 
    </form>
    <button name="hide" id="hideButton" class="btn btn-success">Hide</button>
    <button name="delete" id="deleteButton" class="btn btn-success">Delete</button>
    <a name="hImage" type="button" id="hidenImages" class="btn btn-success" href="carouselForm.php?folder_name=<?php echo $folderName.'&folderId='.$folderId.'&hidden=1' ?>">Hiden images</a>
</div>
<script src='../js/carousel-slider.js'></script>
<script>
$(document).ready(function(){
    $('#submitButton').click(function(){
        var file=$('input[name="image"]')[0].files[0];
        var form_data = new FormData(file); //sends all the input files of the form to server
        $('#form').submit();
    }); 
    var $carousel = $('#carouselExampleIndicators');
    $("#deleteButton").click(function(e) {
        if(!confirm("Are you sure?")){ //display confirmation dialog
            e.preventDefault();
            window.location.reload(); //reloads the current page
        } else {
            var imageId=$('div.active').attr('id'); //gets id of active image
            activeImage(); //removes active image from carousel
            $.ajax({
                url:"imageUpload.php",
                method:'POST',
                data: {'imageId': imageId, 'delete': $(this).val()},
                success: function(){
                    window.location.reload();
                }
            });
        }
    });
    $("#hideButton").click(function(){
        var imageId=$('div.active').attr('id'); //gets id of active image
        activeImage(); //removes active image from carousel
        var hidden=window.location.search.split('=')[3]; //gets hidden parameter value from url
        $.ajax({
            url:"imageUpload.php",
            method:'POST',
            data: {'imageId': imageId, 'hide': $(this).val(),'hidden':hidden},
            success: function(){
               window.location.reload();
            }
        });
    });
    $('#carouselExampleIndicators').carousel({ 
        interval: 5000
    });
    function activeImage(){
        currentIndex = $('div.active').index(); //gets index of the active image
        var ActiveElement = $carousel.find('.item.active');
        ActiveElement.remove(); //removes from carousel active image
        var NextElement = $carousel.find('.item').first(); 
        NextElement.addClass('active'); //sets next image of carousel as active 
    }
});
</script>
</body>
</html>
<?php
} else {
    header("location: loginForm.php"); //redirect to login form if it is not logged in 
}?>