<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Custom Theme files -->
<link href="css/register.css" rel="stylesheet" type="text/css" media="all" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" href="public/register.js"></script>
</head>
<body>
	<!-- main -->
	<div class="main-w3layouts wrapper">
		<div class="main-agileinfo">
			<div class="agileits-top">
				<form method="POST" class="form-class">
					<input class="text" type="text" name="username" placeholder="Username" required="">
					<input class="text email" type="email" name="email" placeholder="Email" required="">
					<input class="text" type="password" name="password" placeholder="Password" required="">
					<input class="text w3lpass" type="password" name="cpassword" placeholder="Confirm Password" required="">
					<div class="wthree-text">
						<label class="anim">
							<input type="checkbox" class="checkbox" required="">
							<span>I Agree To The Terms & Conditions</span>
						</label>
						<div class="clear"> </div>
					</div>
					<button type="button" id="submitButton">Register</button>
					<p class="message">Already have an Account? <a href="loginForm.php"> Login Now!</a></p>
				</form>
			</div>
		</div>
	</div>
	<script>
$('document').ready(function(){
  $('#submitButton').click(function(){
	var data=$('.form-class').serialize();
    $.ajax({
        url:'registerUser.php',
        method:'POST',
        data: data,
        success: function(result){
           if(result==""){
			   window.location.href("loginForm.php");
		   } else {
			   alert(result);
		   }
		}
    });
 });
});
	</script>
</body>
</html>