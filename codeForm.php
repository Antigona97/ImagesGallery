<!Doctype html>
<html>
    <head>
    <link href="css/code.css" rel="stylesheet" type="text/css" media="all" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>
        <form method="POST" class="code-class" action="code.php" id="codeForm">
            <div>
               <label type="text" >Put your code</label>
               <input type="text" placeholder="Code" name="verificationCode" id="code">
               <?php if(isset($_GET['field']) && $_GET['field'] === 'code'){
						echo '<p class="response">'.$_GET['message'].'</p>';
				} ?>
            </div>
            <p class="result"></p>
           <button type="button" id="submitButton">Submit</button>
        </form>
        <script>
               $('#submitButton').click(function(){
                   event.preventDefault();
                   var code=$('#code').val();
                   if(code==''){
                      $('.result').html("You have to put your code");
                   } else {
                    $('#codeForm').submit();
                   }
               });
        </script>
    </body>
</html>