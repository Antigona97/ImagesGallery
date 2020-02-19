<?php session_start();
     if(isset($_GET['folder_name'])) $folderName = $_GET['folder_name']; else $folderName='';
     if(isset($_GET['folderId'])) $folderId = $_GET['folderId']; else $folderId='';
     $_SESSION['folderName']=$folderName;
     $_SESSION['folderId']=$folderId;

     include "slider.php";
?>
<!Doctype html>
<html>
<head>
    <link href="css/image.css" rel="stylesheet" type="text/css" media="all" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <form method="POST" action="imageUpload.php" id="form" enctype="multipart/form-data" class="album-form">
        <div class="row">
            <div class="col-md-5">
                <strong>Image:</strong> </br>
                <input type="file" name="image" class="form-control">
            </div>
            <div class="col-md-2">
                <br/>
                <button type="submit" name="upload" id="submitButton" class="btn btn-success">Upload</button>
                <button id="delete" class="btn btn-success">Delete</button>
            </div>
        </div>
    </form>
    <br/>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="false">
        <div class="carousel-inner">
          <?php echo $slider_html; ?>
          <ol class="carousel-indicators"><?php echo $button_html; ?></ol>
        </div> 
        <br/>
        <div id="thumbnail" class="text-center" class="img-thumbnail">
            <?php echo $thumb_html; ?>
        </div>
        <a class="carousel-control-prev" style='height:500px' href="#carouselExampleIndicators" href="#thumbnail" role="button" data-slide="prev">
           <span class="carousel-control-prev-icon" aria-hidden="true"></span>
           <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" style='height:500px' href="#carouselExampleIndicators" role="button" data-slide="next">
           <span class="carousel-control-next-icon" aria-hidden="true"></span>
           <span class="sr-only">Next</span>
        </a>
    </div>
<script>
    $('#submitButton').click(function(){
        var file=$('input[name="image"]')[0].files[0];
        var form_data = new FormData(file);
        $('#form').submit();
    });
    var $carousel = $('#carouselExampleIndicators');
    $("#delete").click(function() {
        currentIndex = $('div.active').index();
        var ActiveElement = $carousel.find('.item.active');
        ActiveElement.remove();
        var NextElement = $carousel.find('.item').first();
        NextElement.addClass('active');
    });
</script>
</body>
</html>