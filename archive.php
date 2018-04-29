<?php
  session_start();
  include ("resources/dbConnect.php");
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
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="css/stylesheet.css">
  <link rel="icon" href="img/heart-beat-icon.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
</head>
<body id="archivePage" >

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
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">My Results <span class="caret"></span></a>
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
  <h1>Archive</h1>
  <p>Here you can view archived blood results</p>
</div>

<div class="container-fluid container-body">
   <div class="row">
   	<div class="col-sm-8 col-xs-12 col-md-10" >
       <div class="table-responsive">
       	<?php
       				$user=$_SESSION["currentUserID"];
       				$dbQuery=$db->prepare("select category.category, tests.testName, tests.unit, archive.*
                      from category, tests, archive where (archive.userID=:userID) AND (archive.testID=tests.testID)
                      and (category.categoryID=tests.categoryID) order by archive.date desc");
                  $dbParams = array('userID'=>$user);
       				$dbQuery->execute($dbParams);
                  if($dbQuery)
                  {
          		     ?><tbody>

                    <?php if ($dbQuery->rowCount()>0)
                    {
                       ?>
                       <p> This is where your archived blood tests are stored </p>
                        <table class ="table table-hover table-condensed table-responsive" id="resultsTable">
                        <thead>
                        <tr><th>Category</th>
                           <th>Test</th>
                           <th>Result</th>
                           <th>Unit</th>
                           <th>Date</th>
                           <th>Outcome</th>
                           <th>Comments</th>
                       </tr></thead>
                       <?php
                       while ($dbRow=$dbQuery->fetch(PDO::FETCH_ASSOC)) {
                          ?>

                          <tr>
                             <td value="<?php echo $dbRow["category"];?>"> <?php echo $dbRow["category"];?></td>
                			     <td value="<?php echo $dbRow["testName"];?>"> <?php echo $dbRow["testName"];?></td>
                             <td value="<?php echo $dbRow["result"];?>"> <?php echo $dbRow["result"]?></td>
                			     <td value="<?php echo $dbRow["testName"];?>"> <?php echo $dbRow["unit"];?></td>
                			     <td value="<?php echo $dbRow["testName"];?>"> <?php echo $dbRow["date"];?></td>
                			     <td value="<?php echo $dbRow["testName"];?>"> <?php echo $dbRow["outcome"];?></td>
                   			  <td value="<?php echo $dbRow["comments"];?>"> <?php echo $dbRow["comments"]?></td>
                			  </tr>
                        <?php
                        }
                     }
                     else{
                        echo '<div class="alert alert-info"><h3>Looks like you don\'t have any results to display yet</h3></div>';
                     }
                 }
                 else
                 {
                    $message = "Oops, Something went wrong! Error";
                    $errors = $dbQuery->errorInfo();
                    $userError = $errors[2];
                    echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
                    header("Location: login.php");
                 }
           ?>
          </tbody>
          </table>
     	</div>
     </div>
 	</div>
	<div class="row">
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
      <a href="mailto:admin@mybloodresulttracker.co.uk?Subject=Contact%20Us">Contact Us</a>
      <p>&copy; 2018</p>
  </div>
</footer>
</body>
</html>
