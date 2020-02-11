<!Doctype html>
<html>
    <head>
    <link href="css/login.css" rel="stylesheet" type="text/css" media="all" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>
        <div class="login-page">
        <div class="form">
            <form method="POST" class="login-form">
              <input type="text" placeholder="username"/>
              <input type="password" placeholder="password"/>
              <button type="button" name="submit" id="loginButton">login</button>
              <p class="message">Not registered? <a href="#">Create an account</a></p>
            </form>
        </div>
        </div>
    <script>
    $("document").ready(function(){
        $("#loginButton").click(function(){
            var data=$('.login-form').serialize();
            alert(data);
            $.ajax({
                url:"loginUser.php",
                method: 'POST',
                data: data,
                success: function(response){
                    if(response=="success") {
                      window.location.href="home.php";
                    } else {
                        alert("Wrong Details!");
                    }
                }
            });
        });
    });
    </script>
    </body>
</html>