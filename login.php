<?php
	session_start();

	unset($_SESSION['currentUser']);
	unset($_SESSION['currentUserID']);
	unset($_SESSION['access']);

	$formUser=" ";

	if (isset($_POST["action"]) && $_POST["action"]=="login") {

		$formUser=$_POST["username"];
		$formPass=$_POST["password"];

		include("dbConnect.php");
		$dbQuery=$db->prepare("select * from users where username=:formUser");
		$dbParams = array('formUser'=>$formUser);
		$dbQuery->execute($dbParams);
		if($dbQuery)
		{

			$dbRow=$dbQuery->fetch(PDO::FETCH_ASSOC);
			if ($dbRow["username"]==$formUser && $dbRow['accessLevel']=='user') {
				if (password_verify($formPass,$dbRow["Password"]))
				{
					$_SESSION['currentUserID']=$dbRow["userLoginID"];
					$dbQuery=$db->prepare("select * from userInfo where userID=:userLoginID");
					$dbParams = array('userLoginID'=>$_SESSION['currentUserID']);
					$dbQuery->execute($dbParams);
					if ($dbQuery){
						$dbRow=$dbQuery->fetch(PDO::FETCH_ASSOC);
						$DOB = $dbRow["dateofBirth"];
						$dob = new DateTime($DOB);
						$now = new DateTime();
						$difference = $now->diff($dob);
						$age = $difference->y;
						$dbQuery3=$db->prepare("update userInfo set age=:age where userID=:user");
						$dbParams3 = array('age'=>$age,'user'=>$_SESSION['currentUserID']);
						$dbQuery3->execute($dbParams3);
						if($dbQuery3)
						{
							header("Location: homepage.php");
						}
						else{
							$message = "Oops, Something went wrong! Error";
							$errors = $dbQuery3->errorInfo();
							$userError = $errors[2];
							echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
							header("Location: login.php");
						}
					}
				 else{
  			 			$message = "Oops, Something went wrong! Error";
  			 			$errors = $dbQuery->errorInfo();
  			 			$userError = $errors[2];
  			 			echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
						header("Location: login.php");
  			 		}
				}
				else
				{
					header("Location: login.php?fail=2");
				}
			}
			else if ($dbRow["username"]==$formUser && $dbRow['accessLevel']=='admin')
			{
				if (password_verify($formPass,$dbRow["Password"]))
				{
					$_SESSION['currentUserID']=$dbRow["userLoginID"];
					$_SESSION['access']=$dbRow['accessLevel'];
					header("Location: editTests.php");
				}

			}
			else
			{
				header("Location: login.php?fail=1");
			}
		}
		else{
			$message = "Oops, Something went wrong! Error";
			$errors = $dbQuery->errorInfo();
			$userError = $errors[2];
			echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
			header("Location: login.php");
		}
	}
	if (isset($_POST["action"]) && $_POST["action"]=="register") {

		$formUser=$_POST["username"];

		include("dbConnect.php");
		$dbQuery=$db->prepare("select * from users where username=:formUser");
		$dbParams = array('formUser'=>$formUser);
		$dbQuery->execute($dbParams);
		if($dbQuery)
		{
			$dbRow=$dbQuery->fetch(PDO::FETCH_ASSOC);
			if ($dbRow["username"]==$formUser) {
			  header("Location: login.php?fail=3");
			}
		  else {
				$formUser=$_POST["username"];
				$formPass=$_POST["password"];
				$hashedPassword=password_hash($formPass, PASSWORD_DEFAULT);
				$formFirst=$_POST["firstname"];
				$formLast=$_POST["secondname"];
				$formGender=$_POST["gender"];
				$formDOB=$_POST["dob"];
				$user = "user";
				$date = date("Y-m-d");
				$dob = new DateTime($formDOB);
				$now = new DateTime();
				$difference = $now->diff($dob);
				$age = $difference->y;
				$postcode=$_POST["postcode"];

				$dbQuery2=$db->prepare("insert into users values (null, :formUser, :formPass, :date, :user)");
				$dbParams2 = array('formUser'=>$formUser, 'formPass'=>$hashedPassword, 'date'=>$date, 'user'=>$user);
				$dbQuery2->execute($dbParams2);
				if(!$dbQuery2)
				{
					$message = "Oops, Something went wrong! Error";
					$errors = $dbQuery2->errorInfo();
					$userError = $errors[2];
					echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
					header("Location: login.php");
				}

				$dbQuery5=$db->prepare("select * from users where username=:formUser");
				$dbParams5 = array('formUser'=>$formUser);
				$dbQuery5->execute($dbParams5);
				if($dbQuery5)
				{
					$dbRow=$dbQuery5->fetch(PDO::FETCH_ASSOC);
					$userID=$dbRow["userLoginID"];

					$dbQuery3=$db->prepare("insert into userInfo values (:userID, :formFirst, :formLast, :formGender, :formDOB, :age, :postcode)");
					$dbParams3 = array('userID'=>$userID,'formFirst'=>$formFirst, 'formLast'=>$formLast, 'formGender'=>$formGender, 'formDOB'=>$formDOB, 'age'=>$age, 'postcode'=>$postcode);
					$dbQuery3->execute($dbParams3);
					if(!$dbQuery3)
					{
						$message = "Oops, Something went wrong! Error";
						$errors = $dbQuery3->errorInfo();
						$userError = $errors[2];
						echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
						header("Location: login.php");
					}

					$_SESSION['currentUserID']=$userID;
					header("Location: homepage.php");
			 	}
				else
				{
					$message = "Oops, Something went wrong! Error";
					$errors = $dbQuery5->errorInfo();
					$userError = $errors[2];
					echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
					header("Location: login.php");
				}
			}
		}
		else{
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
<body id="loginPage" >

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
  <p>Login and Register</p>
  <?php
	  if (isset($_GET["fail"])) {
		  if ($_GET["fail"]==1)
			  echo '<div class="alert alert-danger"><h3>Incorrect Username or Password, Please try again</h3></div>';
		  if ($_GET["fail"]==2)
			  echo '<div class="alert alert-danger"><h3>Incorrect Username or Password, Please try again</h3></div>';
		  if ($_GET["fail"]==3)
			  echo '<div class="alert alert-danger"><h3>That Username already exists, Please try again</h3></div>';
	  }
  ?>
</div>

<div class="container">
<div class="row">
<div class="col-md-6 col-md-offset-3">
	<div class="panel panel-info">
		<div class="panel-heading text-center">
			<div class="row">
			<div class="col-xs-6" >
			<a href="#" class="active" id="login-form-link">Login</a>
			</div>
			<div class="col-xs-6" >
			<a href="#" id="register-form-link">Register</a>
		</div>
		</div>
	<hr>
</div>
<div class="panel-body">
	<div class="row">
		<div class="col-lg-12">
			<form id="login-form" action="login.php" name="login" method="post" role="form" style="display: block;">
				<div class="form-group">
			 <label for="username">Username:</label>
					<input type="text" name="username" id="login-username" tabindex="1" class="form-control" placeholder="Username" value="" required>
				</div>
				<div class="form-group">
			 		<label for="password">Password:</label>
					<input type="password" name="password" id="login-password" tabindex="2" class="form-control" placeholder="Password" required>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6 col-sm-offset-3">
				  			<input type="hidden" name="action" value="login">
							<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn-info" value="Log In">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-lg-12">
							<div class="text-center">
								<a href="forgotPassword.php" tabindex="5" class="forgot-password">Forgot Password?</a>
							</div>
						</div>
					</div>
				</div>
			</form>
			<form id="register-form" action="login.php" method="post" role="form" style="display: none;">
				<div class="form-group">
			 <label for="username"><span style="color:red">* </span>Username:  <p style="color:red; font-size:10px">This will be your login username</p></label>
					<input type="text" name="username" id="register-username" class="form-control" placeholder="Username" value="" required>
				</div>
				<div class="form-group">
			 <label for="password"><span style="color:red">* </span>Password:</label>
					<input type="password" name="password" id="register-password" class="form-control"  minlength="5" maxlength="20" placeholder="Password" required>
				</div>
				<div class="form-group">
					<input type="password" name="confirm-password" id="confirm-password" class="form-control" minlength="5" maxlength="20" placeholder="Confirm Password" required onkeyup="checkPasswords()">
					<div id="message"></div>
				</div>
		  <div class="form-group">
			 <label for="firstname"><span style="color:red">* </span>Name:</label>
					<input type="text" name="firstname" id="firstname" class="form-control" placeholder="First Name" required onkeyup = "Validate(this)">
				</div>
		  <div class="form-group">
					<input type="text" name="secondname" id="secondname" class="form-control" placeholder="Surname" required onkeyup = "Validate(this)">
				</div>
		  <div class="form-group">
			 <label for="date"><span style="color:red">* </span>Date Of Birth:</label>
					<input type="date" name="dob" id="dob" class="form-control" placeholder="yyyy-mm-dd" value="1970-01-01"required onchange="validateDate()">
				</div>
		  <div class="form-group">
			 <label for="gender"><span style="color:red">* </span>Gender:</label>
				<select class="form-control" name="gender" id="gender" maxOptions="1" placeholder="Gender" required>
				  <option>M</option>
				  <option>F</option>
				</select>
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
				  <input type="hidden" name="action" value="register">
							<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-info" value="Register Now">
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
</div>
</div>
</div>
</div>

</body>
<script type="text/javascript">
$(function() {

	 $('#login-form-link').click(function(e) {
		$("#login-form").delay(100).fadeIn(100);
		$("#register-form").fadeOut(100);
		$('#register-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
	$('#register-form-link').click(function(e) {
		$("#register-form").delay(100).fadeIn(100);
		$("#login-form").fadeOut(100);
		$('#login-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});

});


function checkPasswords()
{
    var password = document.getElementById("register-password");
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
function Validate(text) {
    text.value = text.value.replace(/[^a-zA-Z-'\n\r.]+/g, '');
}

function validateDate()
{
	 var dobPicker = document.getElementById("dob");
    var dob = dobPicker.value;
    var age = GetAge(dob);
    if (age < 18) {
        dobPicker.setCustomValidity("You must be over 18 to use this website");
		  return false;
	  }
	  else{
		  dobPicker.setCustomValidity('');
		  return true;
	  }
}

function GetAge(birthDate) {
    var today = new Date();
	 var birth = new Date(birthDate)
    var age = today.getFullYear() - birth.getFullYear();
    var month = today.getMonth() - birth.getMonth();
    if (month < 0 || (month === 0 && today.getDate() < birth.getDate()))
	 {
        age--;
    }
    return age;
}

</script>
</html>
