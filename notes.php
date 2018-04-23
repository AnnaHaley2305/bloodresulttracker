<?php
    session_start();
    if (!isset($_SESSION['currentUserID']))
    {
      header("Location: login.php");
    }

   include ("dbConnect.php");
   if (isset($_POST["action"]) && $_POST["action"]=="deleteNotes") {
     $dbQuery=$db->prepare("delete from notes where noteID=:id");
     $dbParams = array('id'=>$_POST["noteID"]);
     $dbQuery->execute($dbParams);
     if(!$dbQuery)
     {
        $message = "Oops, Something went wrong! Error";
        $errors = $dbQuery->errorInfo();
        $userError = $errors[2];
        echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
        header("Location: notes.php");
     }
     $message = "Successfully Deleted";
     echo "<script type='text/javascript'>alert('$message');</script>";
}
   // the above headers will prevent the page output from being cached
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Blood Results Tracker</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/stylesheet.css">
  <link rel="icon" href="images/heart-beat-icon.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
</head>
<body id="notesPage" >

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
  <h1>Notes</h1>
  <p>Here you can input and notes</p>
</div>

<div class="container-fluid">
   <p> Here you can enter notes about anything you think may have affected your blood results e.g. Hospital Admissions, Life Events or Medication Changes</p>
   <p> To enter a note please fill in the form below</p>
  <div class="row">
    <div class="col-sm-8 col-xs-12 col-md-5" >
     <form class="form-horizontal" role="form" action="notes.php" method="post">
       <fieldset>
         <legend>Input New Note</legend>
         <div class="form-group">
           <label class="col-sm-2 col-md-3 control-label" for="note">Note</label>
           <div class="col-sm-9 col-md-5">
             <input class="form-control" type="text" name="note" id="note" length=25>
           </div>
         </div>
         <div class="form-group">
           <label class="col-sm-2 col-md-3 control-label" for="start-date">Start Date</label>
           <div class="col-sm-3 col-md-5">
             <input type="date" class="form-control" name="start-date" id="start-date" placeholder="21/11/2017">
           </div>
         </div>
         <div class="form-group">
           <label class="col-sm-2 col-md-3 control-label" for="end-date">End Date</label>
           <div class="col-sm-3 col-md-5">
             <input type="date" class="form-control" name="end-date" id="end-date" placeholder="21/11/2017">
           </div>
         </div>
         <div class="form-group">
           <div class="col-sm-offset-2 col-sm-9">
             <button type="submit" class="btn btn-success"  name="submit" >Submit</button>
           </div>
         </div>
       </fieldset>
     </form>
   </div>
        <div class="table-responsive col-sm-8 col-xs-12 col-md-6">
         <table class ="table table-hover table-responsive table-bordered">

         	<?php	if (isset($_POST["submit"])) {
                     $userID=$_SESSION['currentUserID'];
                     $note = $_POST["note"];
                     $startDate=$_POST["start-date"];
                     $endDate=$_POST["end-date"];
                     $dbQuery=$db->prepare("insert into notes values(null, :user, :noteName, :startDate, :endDate)");
                     $dbParams=array('user'=>$userID,'noteName'=>$note, 'startDate'=>$startDate, 'endDate'=>$endDate);
                     $dbQuery->execute($dbParams);
                     if(!$dbQuery)
                     {
                        $message = "Oops, Something went wrong! Error";
         	 				$errors = $dbQuery->errorInfo();
         	 				$userError = $errors[2];
         	 				echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
         	 				header("Location: graphs.php");
                     }
         		   }
               $userID=$_SESSION['currentUserID'];
               $dbQuery=$db->prepare("select * from notes where userID=:userID order by startDate asc");
               $dbParams = array('userID'=>$userID);
               $dbQuery->execute($dbParams);
               if($dbQuery)
               {
                  if ($dbQuery->rowCount()>0)
                  {
                     ?>
                  <thead>
               	<tr><th>Note Name</th><th>Start Date</th><th>End Date</th><th>Delete</th></tr></thead>
         		   <tbody>
                  <?php
         		   while ($dbRow=$dbQuery->fetch(PDO::FETCH_ASSOC)) {
                     ?>
         			 <tr>
         			 <td> <?php echo $dbRow["noteName"];?></td>
         			 <td> <?php echo $dbRow["startDate"];?></td>
         			 <td> <?php echo $dbRow["endDate"];?></td>
                   <td>
                     <form class="text-center" method="post" action="notes.php">
                        <input type="hidden" name="action" value="deleteNotes">
                        <input type="hidden" name="noteID" value="<?php echo $dbRow['noteID'];?>">
                        <button type="submit" class="btn btn-danger">
                             <i class="glyphicon glyphicon-trash"></i> Delete
                       </button>
                     </form>
                  </td>
         			</tr>
                  <?php
                     }
         		   }
                  else{
                     echo '<div class="alert alert-info"><h3>Looks like you don\'t have any notes to display yet</h3></div>';

                  }
               }
               else
               {
                  $message = "Oops, Something went wrong! Error";
   	 				$errors = $dbQuery->errorInfo();
   	 				$userError = $errors[2];
   	 				echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
   	 				header("Location: graphs.php");
               }
             ?>
            </tbody>
          </table>
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
