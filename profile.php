<?php session_start();
include "pdo_connection.php";
if(isset($_SESSION['userId'])) {
    $userId=$_SESSION['userId'];
    $query="Select * from users where userId=:userId";
    $stmt=$pdo->prepare($query);
    $stmt->bindValue(':userId', $userId);
    $stmt->execute();
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $username=$row['username'];
        $email=$row['email'];

    }
?>
<!Doctype html>
<html>
  <head>
    <link href="css/image.css" rel="stylesheet" type="text/css" media="all" />
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  </head>
<body>
<div class="container">
    <h1>Edit Profile</h1>
    <!--Begin my header.php include -->
        <?php include "header.php"; ?>
    <!-- End my header.php include -->
  	<hr>
	<div class="row">
      <!-- edit form column -->
      <div class="col-md-9 personal-info">
        <h3>Personal info</h3>
        
        <form class="form-horizontal" name="updateProfile" id="profileForm" method="POST" action="updateProfile.php">
          <p class="response"></p>
          <div class="form-group">
            <label class="col-lg-3 control-label">Email:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" name="email" value="<?php echo $email ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">Username:</label>
            <div class="col-md-8">
              <input class="form-control" name="username" type="text" value="<?php echo $username ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">Current password:</label>
            <div class="col-md-8">
              <input class="form-control" name="currentPassword" type="password" value="">
              <?php if(isset($_GET['field']) && $_GET['field']==='currentPassword') {
                  echo '<p class="text-danger" class="response">'.$_GET['message'].'</p>';
              } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">New password:</label>
            <div class="col-md-8">
              <input class="form-control" name="newPassword" type="password" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">Confirm password:</label>
            <div class="col-md-8">
              <input class="form-control" name="confirmPassword" type="password" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-8">
              <input type="submit" id="submitButton" class="btn btn-success" value="Save Changes">
              <span></span>
              <input type="reset" class="btn btn-default" value="Cancel">
            </div>
          </div>
        </form>
      </div>
  </div>
</div>
<hr>
<script>
  $(document).ready(function(){
      $("#submitButton").click(function(event){
            event.preventDefault();
            var username=$('input[name="username"]').val();
            var email=$('input[name="email"]').val();
            var currentPassword=$('input[name="currentPassword"]').val();
            var newPassword=$('input[name="newPassword"]').val();
            var confirmPassword=$('input[name="confirmPassword"]').val();
            if(username=='' || email=='' || currentPassword=='' || newPassword=='' || confirmPassword==''){
                $(".response").html("Please fill all the fields!");
            }else{
                $('#profileForm').submit();
            }
        });
  });
</script>
</body>
</html>
<?php }
  else {
      header("location: loginForm.php");
  }
?>