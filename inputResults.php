<?php
	session_start();
	include ("dbConnect.php");
	if (!isset($_SESSION['currentUserID']))
	{
		header("Location: login.php");
	}
	if (isset($_POST["submit"])) {
	   $userID=$_SESSION['currentUserID'];
	   $categoryID = $_POST["category"];
	   $testID=$_POST["test"];
	   $result=$_POST["results"];
	   $rangeID=$_POST["range"];
	   $decimalResult=$_POST["results-decimal"];
	   $fullResult= $result.'.'.$decimalResult;
	   $date=$_POST["date"];
	   $comment=$_POST["comment"];

	   $dbQuery2=$db->prepare("select * from ranges where rangeID=:rangeID");
	   $dbParams2=array('rangeID'=>$rangeID);
	   $dbQuery2->execute($dbParams2);
		if($dbQuery2)
		{
		   while ($dbRow=$dbQuery2->fetch(PDO::FETCH_ASSOC)) {
			  $lowRange = $dbRow['lowRange'];
			  $highRange = $dbRow['highRange'];
		   }
		   if ($fullResult < $lowRange)
		   {
				$outcome = "low";
		   }
		   elseif ($fullResult > $highRange)
		   {
				$outcome = "high";
		   }
		   else {
				$outcome="normal";
		   }
		   $dbQuery=$db->prepare("insert into results values(null, :user, :tests, :range, :result, :date, :outcome, :comment)");
		   $dbParams=array('user'=>$userID, 'tests'=>$testID, 'range'=>$rangeID, 'result'=>$fullResult, 'date'=>$date, 'outcome'=>$outcome, 'comment'=>$comment);
		   $dbQuery->execute($dbParams);
			if(!$dbQuery){
				$message = "Oops, Something went wrong! Error";
				$errors = $dbQuery->errorInfo();
				$userError = $errors[2];
				echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
				header("Location: inputResults.php");
			}
		   $url = "http://mybloodresulttracker.co.uk/results.php";
		   echo '<script>window.location = "'.$url.'";</script>';
	   	die;
		}
		else
		{
			$message = "Oops, Something went wrong! Error";
			$errors = $dbQuery2->errorInfo();
			$userError = $errors[2];
			echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
			header("Location: inputResults.php");
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
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
</head>
<body id="inputResultsPage" >

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
	 <div class="collapse navbar-collapse" id="myNavbar">
		<ul class="nav navbar-nav navbar-right">
		  <li><a href="homepage.php">My Dashboard</a></li>
		  <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">My Results<span class="caret"></span></a>
		  <ul class="dropdown-menu">
			 <li><a href="inputResults">Input Results</a></li>
			 <li><a href="results">Show Results</a></li>
		  </ul>
			 </li>
		  <li><a href="graphs.php">My Graphs</a></li>
		  <li><a href="notes.php">My Notes</a></li>
		  <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Help <span class="caret"></span></a>
		  <ul class="dropdown-menu">
		  <li><a href="help">Help</a></li>
			 <li><a href="myAccount">My Account</a></li>
			 <li><a href="logout">Logout</a></li>
			<li><a href="archive">Archive</a></li>
		  </ul>
		</li>
	</div>
		</ul>
	 </div>
  </div>
</nav>
<script type="text/javascript">

$(document).ready(function() {
  $("#category").change(function() {
	 var categoryID = " ";
	 categoryID = $(this).val();
	 if(categoryID != "") {
		$.ajax({
		  url:"getTests.php",
		  data:{id:categoryID},
		  type: 'post',
		  dataType:'json',
		  success:function(response)
		  {
			 var len = response.length;
			 $("#test").empty();
			 for( var i = 0; i<len; i++)
			 {
				  var id = response[i]['id'];
				  var name = response[i]['name'];
				  $("#test").append("<option value='"+id+"'>"+name+"</option>");
			 }
		 }
		});
	 } else {
		$("#test").html("<option value=''> -- select -- </option>");
	 }
 });
 $("#test").change(function() {
	var testID = " ";
	testID = $(this).val();
	if(testID != "")
	{
	  $.ajax({
		url:"getRanges.php",
		data:{id:testID},
		type: 'post',
		dataType:'json',
		success:function(response)
		{
		 var len = response.length;
		 $("#range").empty();
			for( var i = 0; i<len; i++)
			{
				 var id = response[i]['id'];
				 var name = response[i]['name'];
				 $("#range").append("<option value='"+id+"'>"+name+"</option>");

			}
		}
		})
	}
	else
	{
	  $("#range").html("<option value=''> -- select -- </option>");
	}
	}).click(function(){
	if($('#test').length == 1)
	{
		$('#test').change();
	}
	});
});

$(document).ready(function(){
    $('[data-toggle="popover"]').popover();
});


function validateDate()
{
	 var datePicker = document.getElementById("date");
    var date = datePicker.value;
    var today = new Date();
	 var setDate = new Date(date)
    if (setDate > today) {
        datePicker.setCustomValidity("This date is in the future");
		  return false;
	  }
	  else{
		  datePicker.setCustomValidity('');
		  return true;
	  }
}

</script>
<div class="jumbotron text-center">
  <h1>Input Results</h1>
  <p>Here you can input your blood results</p>
</div>

<div class="container-fluid">
	<div class="row">
		<p> Fill in the form below to add your test result </p>
		<div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
	   <form class="form-horizontal" role="form" action="inputResults.php" method="post">
		 <fieldset>
			<legend>Input Results</legend>
			<div class="form-group">
			  <label class="col-sm-2 control-label" for="category">Category</label>
			  <div class="col-sm-9 col-md-8">
				 <select class="form-control col-sm-2 col-md-4" name="category" id="category" required>
					<option value="">Category</option>
					<?php
						$dbQuery=$db->prepare("select * from category");
						$dbQuery->execute();
						while ($dbRow=$dbQuery->fetch(PDO::FETCH_ASSOC)) {
							 echo "<option value='".$dbRow["categoryID"]."'>".$dbRow["category"]."</option>";
						}
					?>
				 </select>
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-sm-2 col-md-2 control-label" for="test">Test Name</label>
			  <div class="col-sm-9 col-md-8 col-lg-8">
				 <select class="form-control col-sm-2 col-md-4" name="test" id="test" required>
					<option value="">Test</option>
				 </select>
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-sm-2 col-md-2 control-label" for="range">Range</label>
			  <div class="col-sm-9 col-md-8">
				 <select class="form-control col-sm-2 col-md-4" name="range" id="range" required>
					<option value="">Range</option>
				 </select>
			  </div>

			</div>
			<div class="form-group">
			  <label class="col-sm-2 control-label" for="result">Result</label>
					<div class="col-sm-8 col-md-4">
					<div class="input-group multi-control-group" id="result">
					  <input type="number" class="form-control" name="results" value="0" min="0" max="999" step="1" pattern="[0-9]{3}" required>
					  <span class="input-group-addon"><b>.</b></span>
					  <input type="number" class="form-control" name="results-decimal" value="00" min="00" max="99" pattern="[0-9]{2}" step="01" required>
					</div>
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-sm-2 col-md-2 control-label" for="date">Date</label>
			  <div class="col-sm-3 col-md-8">
				 <input type="date" class="form-control" name="date" id="date" placeholder="21/11/2017" required onchange="validateDate()">
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-sm-2 col-md-2 control-label" for="comment">Comment</label>
			  <div class="col-sm-3 col-md-8">
				 <input type="text" class="form-control" name="comment" id="comment" placeholder="Comment">
			  </div>
			</div>
			<div class="form-group">
			  <div class="col-sm-offset-2 col-sm-9 col-md-offset-2 col-md-4">
				 <button type="submit" class="btn btn-success" name="submit">Submit</button>
			  </div>
			</div>
		 </fieldset>
	  </form>
	</div>
	<div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
		<p>
			If there is a Category, Test or Range you would like to be added please press the button below and send an email containing the details below.
		</p>
		<P>
			Please provide the Category Name, Test Name, Test Unit, Gender, Age Range (if known) and the Reference Ranges for each test.
		</P>
		<a class="btn btn-success" href="mailto:admin@mybloodresulttracker.com?Subject=Add%20tests" target="_top"><span class="glyphicon glyphicon-envelope"></span> Request new test</a>
	</div>
</div>
</div>
<footer class="container-fluid">
  <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4 text-left">
	  <h5> Useful Links </h5>
	  <a href="https://www.nhs.uk/CHQ/Pages/home.aspx"> NHS Common Health Questions</a><br />
	  <a href="https://www.nhs.uk/news/">NHS News</a><br />
	  <a href="https://www.nhs.uk/LiveWell/Pages/Livewellhub.aspx">NHS Live Well</a><br />
  </div>
  <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4 text-center">
	  <a href="homepage" title="To Top">
		  <span class="glyphicon glyphicon-home"></span>
	  </a>
  </div>
  <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4 text-right">
		<h5> About Us </h5>
		<a href="mailto:admin@mybloodresulttracker.com?Subject=Contact%20Us">Contact Us</a>
		<p>&copy; 2018</p>
  </div>
</footer>
</body>
</html>
