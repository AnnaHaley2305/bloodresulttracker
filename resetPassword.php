<?php
	session_start();
	include("resources/dbConnect.php");
   if (!isset($_SESSION['currentUserID']))
   {
     header("Location: login.php");
   }
   if (isset($_POST["action"]) && $_POST["action"]=="resetPassword")
	{
		$password=$_POST['password'];
		$hashedPassword=password_hash($password, PASSWORD_DEFAULT);
		$dbQuery3=$db->prepare("update users set password=:password where userLoginID=:user");
		$dbParams3 = array('password'=>$hashedPassword,'user'=>$_SESSION['currentUserID']);
		$dbQuery3->execute($dbParams3);
		if(!$dbQuery3)
		{
			$message = "Oops, Something went wrong! Error";
			$errors = $dbQuery3->errorInfo();
			$userError = $errors[2];
			echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
			header("Location: forgotPassword.php");
			unset($_SESSION['correctDetails']);
		}
		unset($_SESSION['correctDetails']);
		header("Location: homepage");

	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Blood Results Tracker</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-responsive.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/stylesheet.css">
  <link rel="icon" href="img/heart-beat-icon.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
</head>
<body id="resetPasswordPage" >

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
	 <div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="homepage.php"><img src="img/Logo3" width="250" height="30"></a>
	 </div>
	 </div>
  </div>
</nav>
<script type="text/javascript">
function checkPasswords()
{
    var password = document.getElementById("password");
    var passwordConfirm= document.getElementById("confirm-password");
    var message = document.getElementById("message");
    if(password.value == passwordConfirm.value){
		  passwordConfirm.setCustomValidity('');
        message.innerHTML = "<span class=\"alert alert-success\" style=\"margin-top: 15px; padding: 0;\">Passwords Match</span>";
		  return true;
    }else{
		  passwordConfirm.setCustomValidity("Passwords Don't Match");
        message.innerHTML = "<span class=\"alert alert-danger\" style=\"margin-top: 15px; padding: 0;\">Passwords Don't Match</span>";
		  return false;
    }
}


</script>
<div class="jumbotron text-center">
  <h1>Blood Results Tracker</h1>
  <p>Password Reset</p>
</div>

<div class="container">
<?php if (isset($_SESSION['correctDetails'])||isset($_SESSION['currentUserID'])){
?>
<div class="row">
<div class="col-md-6 col-md-offset-3">
			<form id="password-reset-form" action="resetPassword.php" name="resetPassword" method="post" role="form" style="display: block;">
				<div class="form-group">
			 	<label for="password">Password:</label>
					<input type="password" name="password" id="password" minlength="5" maxlength="20" class="form-control" placeholder="Password" required>
				</div>
				<div class="form-group">
					<input type="password" name="confirm-password" id="confirm-password" minlength="5" maxlength="20" class="form-control" placeholder="Confirm Password" required onkeyup="checkPasswords(); return false;">
					<span id='message'></span>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6 col-sm-offset-3">
				  			<input type="hidden" name="action" value="resetPassword">
							<input type="submit" name="reset-submit" id="reset-submit" class="form-control btn-info" value="Reset Password">
						</div>
					</div>
				</div>
			</form>
		</div>
</div>


<?php
} else
{
	header("Location: login.php");

 }?>
</div>
</body>
</html>
