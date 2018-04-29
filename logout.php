<?php

   session_start();
   include ("resources/dbConnect.php");
   $date = date("Y-m-d");
   $dbQuery2=$db->prepare("update users set lastAccessed=:date where userLoginID=:user");
   $dbParams2 = array('date'=>$date,'user'=>$_SESSION['currentUserID']);
   $dbQuery2->execute($dbParams2);
   session_destroy();
   header ("Location: login.php");

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
<body id="logoutPage" >

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
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="homepage.php">My Dashboard</a></li>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">My Results<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="inputResults">Input Results</a></li>
          <li><a href="results">Show Results</a></li>
          <li><a href="archive">Archive</a></li>
        </ul>
		</li>
        <li><a href="graphs.php">My Graphs</a></li>
        <li><a href="notes.php">My Notes</a></li>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">More <span class="caret"></span></a>
        <ul class="dropdown-menu">
		  <li><a href="help">Help</a></li>
          <li><a href="myAccount">My Account</a></li>
          <li><a href="logout">Logout</a></li>

        </ul>
		</li>
	</div>
      </ul>
    </div>
  </div>
</nav>

<div class="jumbotron text-center">
  <h1>Logout</h1>
  <p>Here you can logout of the app</p>
</div>

<div id="about" class="container-fluid">
  <div class="row">
    <div class="col-sm-8">
    </div>
    <div class="col-sm-4">
      <span class="glyphicon glyphicon-signal logo"></span>
    </div>
  </div>
</div>
</body>
</html>
