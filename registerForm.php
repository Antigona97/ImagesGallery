<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Custom Theme files -->
<link href="css/register.css" rel="stylesheet" type="text/css" media="all" />
<!-- //Custom Theme files -->
<!-- web font -->
<link href="//fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,700,700i" rel="stylesheet">
<!-- //web font -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" href="public/register.js"></script>
</head>
<body>
	<!-- main -->
	<div class="main-w3layouts wrapper">
		<h1>Register</h1>
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
				</form>
				<p>Already have an Account? <a href="#"> Login Now!</a></p>
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
        success: function(data){
           $('.login').html(data);
        },
        error: function () {
         alert("Errorrr");
       }
    });
 });
});
	</script>
</body>
</html>