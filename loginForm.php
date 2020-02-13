<!Doctype html>
<html>
    <head>
    <link href="css/login.css" rel="stylesheet" type="text/css" media="all" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>
        <div class="login-page">
        <div class="form">
            <form method="POST" class="login-form" id="login" action="loginUser.php">
                <p class="response"></p>
              <input type="text" name="username" placeholder="username"/>
              <?php if(isset($_GET['field']) && $_GET['field']==='username') {
                  echo '<p class="text-danger" class="response">'.$_GET['message'].'</p>';
              } ?>
              <input type="password" name="password" placeholder="password"/>
              <?php if(isset($_GET['field']) && $_GET['field']==='password') {
                  echo '<p class="text-danger" class="response">'.$_GET['message'].'</p>';
              } ?>
              <button type="button" name="submitButton" id="loginButton">login</button>
              <p class="message">Not registered? <a href="#">Create an account</a></p>
            </form>
        </div>
        </div>
    <script>
        $("#loginButton").click(function(){
            event.preventDefault();
            var username=$('input[name="username"]').val();
            var password=$('input[name="password"]').val();
            if(username=='' || password==''){
                $(".response").html("Please fill all the fields!");
            }else{
                $('#login').submit();
            }
        });
    </script>
    </body>
</html>