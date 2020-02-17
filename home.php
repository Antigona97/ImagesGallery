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
    <form method="POST" action="imageUpload.php" id="form" enctype="multipart/form-data" class="album-form">
        <div class="row">
            <div class="col-md-5">
                <strong>Image:</strong> </br>
                <input type="file" name="image" class="form-control">
            </div>
            <div class="col-md-2">
                <br/>
                <button type="submit" name="upload" id="submitButton" class="btn btn-success">Upload</button>
            </div>
        </div>
        
    </form>
<script>
        $('#submitButton').click(function(){
           var file=$('input[name="image"]')[0].files[0];
           var form_data = new FormData(file);
           $('#form').submit();
        });
        $('document').ready(function(){
        });;
</script>
</body>
</html>