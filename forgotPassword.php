<?php
	session_start();
	include("dbConnect.php");
	unset($_SESSION['currentUser']);
	unset($_SESSION['currentUserID']);
	unset($_SESSION['access']);

	$formUser=" ";

	if (isset($_POST["action"]) && $_POST["action"]=="forgotPassword") {

		$formUser=$_POST["username"];
		$DOB=$_POST["dob"];
		$postcode=$_POST["postcode"];

		unset($_SESSION['correctDetails']);
		$dbQuery=$db->prepare("select * from users where username=:formUser");
		$dbParams = array('formUser'=>$formUser);
		$dbQuery->execute($dbParams);
		if($dbQuery)
		{
			$dbRow=$dbQuery->fetch(PDO::FETCH_ASSOC);
			if ($dbRow["username"]==$formUser) {
				$dbQuery2=$db->prepare("select * from userInfo where userID=:userLoginID");
				$dbParams2 = array('userLoginID'=>$dbRow['userLoginID']);
				$dbQuery2->execute($dbParams2);
				if($dbQuery2)
				{
					$dbRow=$dbQuery2->fetch(PDO::FETCH_ASSOC);
					if ($dbRow["dateofBirth"]==$DOB && $dbRow["Postcode"]==$postcode)
					{
						$_SESSION['currentUserID']=$dbRow["userID"];
						$_SESSION['correctDetails'] = True;
						header("Location: resetPassword");
					}
					else
					{
						echo "<script type='text/javascript'>alert('Those details aren't correct, Try again!');</script>";
					}
				}
				else
				{
					$message = "Oops, Something went wrong! Error";
					$errors = $dbQuery2->errorInfo();
					$userError = $errors[2];
					echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
					header("Location: login.php");
				}
			}
			else{
				echo "<script type='text/javascript'>alert('Those details aren't correct, Try again!');</script>";
			}
		}
		else {
			$message = "Oops, Something went wrong! Error";
			$errors = $dbQuery->errorInfo();
			$userError = $errors[2];
			echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
			header("Location: login.php");
		}



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
  <link rel="icon" href="images/heart-beat-icon.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
</head>
<body id="forgotPasswordPage" >

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
	 <div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="homepage.php"><img src="images/Logo3" width="250" height="30"></a>
	 </div>
	 </div>
  </div>
</nav>

<div class="jumbotron text-center">
  <h1>Blood Results Tracker</h1>
  <p>Password Reset</p>
</div>

<div class="container">
<div class="row">
<div class="col-md-6 col-md-offset-3">
	<div class="panel panel-info">
		<div class="panel-heading text-center">
			<h3>Please enter your details</h3>
		</div>
		<div class="panel-body">
			<form id="forgot-form" action="forgotPassword.php" name="forgotPassword" method="post" role="form" style="display: block;">
				<div class="form-group">
			 		<label for="username">Username:</label>
					<input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
				</div>
				<div class="form-group">
			 		<label for="dob"><span style="color:red">* </span>Date of Birth:</label>
					<input type="date" name="dob" id="dob" class="form-control" required>
				</div>
				<div class="form-group">
	 			 <label for="postcode"><span style="color:red">* </span>Postcode:</label>
	 					<input type="text" name="postcode" id="postcode" class="form-control" placeholder="Postcode" required
						pattern="[A-Za-z]{1,2}[0-9Rr][0-9A-Za-z]? [0-9][ABD-HJLNP-UW-Zabd-hjlnp-uw-z]{2}$"
						oninvalid="this.setCustomValidity('Please provide a valid UK Postcode')"
						oninput="this.setCustomValidity('')">
	 				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6 col-sm-offset-3">
				  			<input type="hidden" name="action" value="forgotPassword">
							<input type="submit" name="forgot-submit" id="forgot-submit" class="form-control btn-info" value="Check Details">
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
</div>
</div>


</body>
</html>
