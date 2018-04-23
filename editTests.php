<?php
	include ("dbConnect.php");
	session_start();
	if (!isset($_SESSION['currentUserID']))
	{
	  header("Location: login.php");
	}
	else if (!isset($_SESSION['access']))
	{
		header("Location: homepage.php");
	}

	if (isset($_POST["action"]) && $_POST["action"]=="deleteResults") {
		$dbQuery=$db->prepare("delete from results where resultID=:id");
		$dbParams = array('id'=>$_POST["resultID"]);
		$dbQuery->execute($dbParams);
		if(!$dbQuery)
		{
			$message = "Oops, Something went wrong! Error";
			$errors = $dbQuery->errorInfo();
			$userError = $errors[2];
			echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
			header("Location: editTests.php");
		}
	}

	if  (isset($_POST["action"]) && $_POST["action"]=="addCategory") {
		$categoryName = $_POST["category"];
		$dbQuery=$db->prepare("insert into category values(null, :category)");
		$dbParams=array('category'=>$categoryName);
		$dbQuery->execute($dbParams);
		if(!$dbQuery)
		{
			$message = "Oops, Something went wrong! Error";
			$errors = $dbQuery->errorInfo();
			$userError = $errors[2];
			echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
			header("Location: editTests.php");
		}
	}
	if  (isset($_POST["action"]) && $_POST["action"]=="addTest") {
		$categoryID = $_POST["category"];
		$testName = $_POST["test"];
		$unit = $_POST["unit"];
		$dbQuery=$db->prepare("insert into tests values(null, :category, :unit, :testName)");
		$dbParams=array('category'=>$categoryID,'unit'=>$unit,'testName'=>$testName );
		$dbQuery->execute($dbParams);
		if(!$dbQuery)
		{
			$message = "Oops, Something went wrong! Error";
			$errors = $dbQuery->errorInfo();
			$userError = $errors[2];
			echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
			header("Location: editTests.php");
		}
	}
	if  (isset($_POST["action"]) && $_POST["action"]=="addRange") {
		$testID = $_POST["test"];
		$gender = $_POST["gender"];
		$startAge = $_POST["startAge"];
		$endAge = $_POST["endAge"];
		$lowRange = $_POST["lowRange"];
		$highRange = $_POST["highRange"];

		$dbQuery=$db->prepare("insert into ranges values(null, :test, :gender, :startAge, :endAge, :lowRange, :highRange)");
		$dbParams=array('test'=>$testID,'gender'=>$gender,'startAge'=>$startAge, 'endAge'=>$endAge, 'lowRange'=>$lowRange, 'highRange'=>$highRange);
		$dbQuery->execute($dbParams);
		if(!$dbQuery)
		{
			$message = "Oops, Something went wrong! Error";
			$errors = $dbQuery->errorInfo();
			$userError = $errors[2];
			echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
			header("Location: editTests.php");
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
<body id="editTestsPage" >

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
	 <div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="editTests.php"><img src="images/Logo3" width="250" height="30"></a>
	 </div>
	 <div class="collapse navbar-collapse" id="myNavbar">
		<ul class="nav navbar-nav navbar-right">
		  <li><a href="logout">Logout</a></li>
		</ul>
	</div>
  </div>
</nav>

<div class="jumbotron text-center">
  <h1>Add Test Information</h1>
  <p>Admin services</p>
  <p>Add categories, tests and ranges</p>
</div>

<div class="container-fluid">
	  <form class="form-horizontal" role="form" action="editTests.php" method="post">
		 <fieldset>
			<legend>Add Category</legend>
			<div class="form-group">
			  <label class="col-sm-2 control-label" for="category">Category</label>
			  <div class="col-sm-9 col-md-4">
				 <div class="form-group">
					 <input type="text" class="form-control" name="category" id="category" placeholder="Category" required>
				  </div>
				</div>
			  </div>
			<div class="form-group">
			  <div class="col-sm-offset-2 col-sm-9">
				  <input type="hidden" name="action" value="addCategory">
				 <button type="submit" class="btn btn-success" name="addCategory">Submit</button>
			  </div>
			</div>
		</fieldset>
	</form>

	<form class="form-horizontal" role="form" action="editTests.php" method="post">
		<fieldset>
		  <legend>Add Tests</legend>
			<div class="form-group">
				 <label class="col-sm-2 control-label" for="category">Category</label>
			 <div class="form-group col-sm-2 col-md-4 col-lg-4">
			<select class="form-control" name="category" id="category" required>
			  <option value="">Category</option>
			  <?php
				  $dbQuery=$db->prepare("select * from category");
				  $dbQuery->execute();
				  if($dbQuery)
				  {
					  while ($dbRow=$dbQuery->fetch(PDO::FETCH_ASSOC)) {
							echo "<option value='".$dbRow["categoryID"]."'>".$dbRow["category"]."</option>";
					  }
			  	  }
				  else
				  {
			  			$message = "Oops, Something went wrong! Error";
			  			$errors = $dbQuery->errorInfo();
			  			$userError = $errors[2];
			  			echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
			  			header("Location: editTests.php");
				  }
			  ?>
			</select>
		</div>
	</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="test">Test</label>
			<div class="col-sm-9 col-md-4">
			 <div class="form-group">
				 <input type="text" class="form-control" name="test" id="test" placeholder="Test" required>
			 </div>
			 </div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="unit">Unit</label>
				<div class="col-sm-9 col-md-4">
				 <div class="form-group">
					 <input type="text" class="form-control" name="unit" id="unit" placeholder="Unit" required>
				 </div>
				 </div>
				</div>
			<div class="form-group">
			<div class="col-sm-offset-2 col-sm-9">
			<input type="hidden" name="action" value="addTest">
			 <button type="submit" class="btn btn-success" name="addTest">Submit</button>
			</div>
		</div>
	 </fieldset>
	</form>

	<form class="form-horizontal" role="form" action="editTests.php" method="post">
	  <fieldset>
		 <legend>Add Ranges</legend>
		  <div class="form-group">
  			<label class="col-sm-2 control-label" for="test">Test</label>
			<div class="form-group col-sm-2 col-md-4 col-lg-4">
			<select class="form-control " name="test" id="test" required>
			  <option value="">Test</option>
			  <?php
				  $dbQuery=$db->prepare("select * from tests");
				  $dbQuery->execute();
				  if($dbQuery)
				  {
					  while ($dbRow=$dbQuery->fetch(PDO::FETCH_ASSOC)) {
							echo "<option value='".$dbRow["testID"]."'>".$dbRow["testName"]."</option>";
					  }
				  }
				  else
				  {
					   $message = "Oops, Something went wrong! Error";
			  			$errors = $dbQuery->errorInfo();
			  			$userError = $errors[2];
			  			echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
			  			header("Location: editTests.php");
				  }
			  ?>
			</select>
		</div>
	</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="gender">Gender</label>
			<div class="col-sm-9 col-md-4">
			 <div class="form-group">
				 <select class="form-control" name="gender" id="gender" required>
					<option value="B">Both</option>
					<option value="M">Male</option>
					<option value="F">Female</option>
				</select>
			 </div>
			 </div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="startAge">Start Age</label>
				<div class="col-sm-9 col-md-4">
				 <div class="form-group">
					 <input type="text" class="form-control" name="startAge" id="startAge" placeholder="Start Age" required>
				 </div>
				 </div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="endAge">End Age</label>
				<div class="col-sm-9 col-md-4">
				 <div class="form-group">
					 <input type="text" class="form-control" name="endAge" id="endAge" placeholder="End Age" required>
				 </div>
				 </div>
				</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="lowRange">Low Range</label>
				<div class="col-sm-9 col-md-4">
				 <div class="form-group">
					 <input type="text" class="form-control" name="lowRange" id="lowRange" placeholder="Low Range" required>
				 </div>
				 </div>
				</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="highRange">High Range</label>
				<div class="col-sm-9 col-md-4">
				 <div class="form-group">
					 <input type="text" class="form-control" name="highRange" id="highRange" placeholder="High Range" required>
				 </div>
				 </div>
				</div>

			<div class="form-group">
			<div class="col-sm-offset-2 col-sm-9">
				<input type="hidden" name="action" value="addRange">
			 <button type="submit" class="btn btn-success" name="addRange">Submit</button>
			</div>
		</div>
	</fieldset>
	</form>
	</div>
</body>
</html>
