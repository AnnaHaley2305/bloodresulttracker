<?php
  session_start();
  include ("dbConnect.php");
  if (!isset($_SESSION['currentUserID']))
  {
    header("Location: login.php");
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
<body id="homepagePage" >

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
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">My Results <span class="caret"></span></a>
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

<div class="jumbotron text-center">
  <h1>Blood Results Tracker</h1>
</div>
<?php
   $user=$_SESSION["currentUserID"];
   $dbQuery=$db->prepare("select * from users, userInfo where (users.userLoginID=:userLoginID)
   AND (userInfo.userID=:userID)");
   $dbParams = array('userID'=>$user,'userLoginID'=>$user);
   $dbQuery->execute($dbParams);
   while ($dbRow=$dbQuery->fetch(PDO::FETCH_ASSOC)) {
     $firstname = $dbRow["firstName"];
     $secondname = $dbRow["surname"];
     $lastAccessed = $dbRow["lastAccessed"];
  }
?>
<div class="container-fluid text-center">
  <div class="row">
    <div class="col-md-offset-4 col-sm-8 col-md-4 col-lg-4">
      <h2>My Dashboard</h2>
      <h4>Hello, <?php echo $firstname." ".$secondname; ?></h4>
      <p class="alert alert-info">You last logged in on <?php echo $lastAccessed; ?>.</p>
      <br>
    </div>
   </div>
   <div class="row">
      <h4>My Blood Results Tracker Services</h4>
      <p> My Blood Results Tracker offers a range of services to help you manage your blood results.</p>
      <br>
        <div class="col-sm-4">
             <div class="panel panel-homepage">
               <div class="panel-heading-homepage">
                  <h4>View Graphs</h4>
               </div>
               <div class="panel-body">
                  <a href="graphs.php">
                   <span class="glyphicon glyphicon-stats"></span>
                   <p>Click here to view your graphs</p>
                   </a>
               </div>
          </div>
      </div>
        <div class="col-sm-4">
            <div class="panel panel-homepage">
               <div class="panel-heading-homepage">
                  <h4>Add results</h4>
               </div>
               <div class="panel-body">
                  <a href="inputResults.php">
                     <span class="glyphicon glyphicon-list-alt"></span>
                  <p>Click here to add blood test results</p>
               </a>
           </div>
        </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-homepage">
               <div class="panel-heading-homepage">
                  <h4>View Results</h4>
               </div>
               <div class="panel-body">
                  <a href="results.php">
                     <span class="glyphicon glyphicon-th-list"></span>
                  <p>Click here to view blood test results</p>
               </a>
           </div>
        </div>
        </div>
   </div>
      <div class="row">
         <div class="col-sm-4">
             <div class="panel panel-homepage">
                <div class="panel-heading-homepage">
                   <h4>My Account</h4>
                </div>
                <div class="panel-body">
                   <a href="myAccount.php">
                      <span class="glyphicon glyphicon-user"></span>
                   <p>Click here to view your account</p>
                </a>
            </div>
         </div>
         </div>
         <div class="col-sm-4">
             <div class="panel panel-homepage">
                <div class="panel-heading-homepage">
                   <h4>View Archive</h4>
                </div>
                <div class="panel-body">
                   <a href="archive.php">
                      <span class="glyphicon glyphicon-folder-open"></span>
                   <p>Click here to view your archive</p>
                </a>
            </div>
         </div>
         </div>
         <div class="col-sm-4">
             <div class="panel panel-homepage">
                <div class="panel-heading-homepage">
                   <h4>Add notes</h4>
                </div>
                <div class="panel-body">
                   <a href="notes.php">
                      <span class="glyphicon glyphicon-list"></span>
                   <p>Click here to add and view your notes</p>
                </a>
            </div>
         </div>
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
