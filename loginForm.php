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
                    <?php if(isset($_GET['field']) && $_GET['field']==='username') { //displays error from server
                        echo '<p class="text-danger" class="response">'.$_GET['message'].'</p>';
                    } ?>
                <input type="password" name="password" placeholder="password"/>
                    <?php if(isset($_GET['field']) && $_GET['field']==='password') { //displays error from server
                        echo '<p class="text-danger" class="response">'.$_GET['message'].'</p>';
                    } else if(isset($_GET['field']) && $_GET['field']==='verify'){
                        echo '<p class="generateCodeLink">'.$_GET['message'].'
                             <a id="verifyLink" href="codeForm.php">Generate a new code</a></p>'; //displays error from server
                    }?>
                <button type="button" name="submitButton" id="loginButton">login</button>
                <p class="message">Not registered? <a href="registerForm.php">Create an account</a></p>
            </form>
        </div>
        </div>
    <script>
    $(document).ready(function(){
        $("#loginButton").click(function(){ //gets input values
            event.preventDefault();
            var username=$('input[name="username"]').val();
            var password=$('input[name="password"]').val();
            if(username=='' || password==''){
                $(".response").html("Please fill all the fields!");
            }else{
                $('#login').submit();
            }
        });
    });
        $('#verifyLink').click(function(){
            var email=window.location.search.split('=')[3];
            console.log(email);
            $.ajax({
                url:"updateCode.php",
                method:"POST",
                data:{'email':email}
            });
        });
    </script>
    </body>
</html>