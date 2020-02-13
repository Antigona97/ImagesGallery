<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link href="css/register.css" rel="stylesheet" type="text/css" media="all" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
	<!-- main -->
	<div class="main-w3layouts wrapper">
		<div class="main-agileinfo">
			<div class="agileits-top">
				<form method="POST" class="form-class" action="registerUser.php" id="register">
				<p class="response"></p>
					<input class="text" type="text" name="username" placeholder="Username" required="Required">
					<?php if(isset($_GET['field']) && $_GET['field']==='username'){
						echo '<p class="text-danger" class="response">'.$_GET['message'].'</p>';
					} ?>
					<input class="text email" type="email" name="email" placeholder="Email" required="Required">
					<?php if(isset($_GET['field']) && $_GET['field'] === 'email'){
						echo '<p class="text-danger" class="response">'.$_GET['message'].'</p>';
					} ?>
					<input class="text" type="password" name="password" placeholder="Password" required="Required">
					<input class="text w3lpass" type="password" name="cpassword" placeholder="Confirm Password" required="Required">
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
	  event.preventDefault();
	var username=$('input[name="username"]').val();
	var email=$('input[name="email"]').val();
	var password=$('input[name="password"]').val();
	var cpassword=$('input[name="cpassword"]').val();
	if(username=='' || email=='' || password=='' || cpassword== ''){
		$(".response").html("Please fill all the fields!");
	} else
	if((password.length)<8) {
       $(".response").html("Your password should be at least 8 characters!");
	} else 
	if(!(cpassword).match(password)){
       $(".response").html("Your passwords doesn't match!");
	} else {
		$('#register').submit();
	}
 });
});
</script>
</body>
</html>