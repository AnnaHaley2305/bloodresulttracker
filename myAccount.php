<?php
  session_start();
  include ("dbConnect.php");
  if (!isset($_SESSION['currentUserID']))
  {
    header("Location: login.php");
  }
  if (isset($_POST["action"]) && $_POST["action"]=="deleteUser")
  {
     $dbQuery5=$db->prepare("delete from userInfo where userID=:user");
     $dbParams5 = array('user'=>$_SESSION['currentUserID']);
     $dbQuery5->execute($dbParams5);
     if(!$dbQuery5)
     {
        $message = "Oops, Something went wrong! Error";
        $errors = $dbQuery5->errorInfo();
        $userError = $errors[2];
        echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
        header("Location:  myAccount.php");
     }
     header("Location: login");

  }
  if (isset($_POST["action"]) && $_POST["action"]=="updateUser")
  {
     $firstname=$_POST['firstname'];
     $surname=$_POST['surname'];
     $postcode=$_POST['postcode'];
     $dbQuery4=$db->prepare("update userInfo set firstName=:firstname, surname=:surname, Postcode=:postcode where userID=:user");
     $dbParams4 = array('firstname'=>$firstname, 'surname'=>$surname, 'postcode'=>$postcode,'user'=>$_SESSION['currentUserID']);
     $dbQuery4->execute($dbParams4);
     if($dbQuery4)
     {
        $message = "Oops, Something went wrong! Error";
        $errors = $dbQuery->errorInfo();
        $userError = $errors[2];
        echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
        header("Location: myAccount.php");
     }
     echo "<script> alert('Changes to your account were saved'); </script>";
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
<body id="myAccountPage" >

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

<div class="jumbotron text-center">
  <h1>My Account</h1>
  <p>Here you can view and edit your account</p>
</div>
<?php
      $user=$_SESSION["currentUserID"];
      $dbQuery=$db->prepare("select * from users, userInfo where (users.userLoginID=:userLoginID)
       AND (userInfo.userID=:userID)");
      $dbParams = array('userID'=>$user,'userLoginID'=>$user);
      $dbQuery->execute($dbParams);
      if($dbQuery)
      {
         while ($dbRow=$dbQuery->fetch(PDO::FETCH_ASSOC)) {
           $firstname = $dbRow["firstName"];
           $secondname = $dbRow["surname"];
           $password = $dbRow["Password"];
           $username = $dbRow["username"];
           $gender = $dbRow["gender"];
           $dob = $dbRow["dateofBirth"];
           $postcode = $dbRow["Postcode"];
         }
      }
      else
      {
         $message = "Oops, Something went wrong! Error";
         $errors = $dbQuery->errorInfo();
         $userError = $errors[2];
         echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
         header("Location: myAccount.php");
      }

 ?>
<div class="container-fluid container-body">
  <div class="row">
    <div class="col-sm-8 col-xs-12 col-md-6" >
     <form class="form-horizontal" role="form" action="myAccount.php" method="post">
       <input type="hidden" name="action" value="updateUser">
       <fieldset>
         <legend>My Account</legend>
         <p>
            If you would like to make any changes to your personal details, edit your details then press save changes.
         </p>
         <div class="form-group">
           <label class="col-sm-2 col-md-3 control-label" for="username">Username: </label>
           <div class="col-sm-9 col-md-5">
             <input class="form-control" type="text" name="firstname" id="firstname"  readonly value=" <?php echo $username ?>">
           </div>
         </div>
         <div class="form-group">
           <label class="col-sm-2 col-md-3 control-label" for="firstname">Firstname:</label>
           <div class="col-sm-9 col-md-5">
             <input class="form-control" type="text" name="firstname" id="firstname" value="<?php echo $firstname ?>">
           </div>
         </div>
         <div class="form-group">
           <label class="col-sm-2 col-md-3 control-label" for="surname">Surname:</label>
           <div class="col-sm-9 col-md-5">
             <input class="form-control" type="text" name="surname" id="surname" value="<?php echo $secondname ?>">
           </div>
         </div>
         <div class="form-group">
           <label class="col-sm-2 col-md-3 control-label" for="dob">Date Of Birth: </label>
             <div class="col-sm-9 col-md-5">
           <input class="form-control" type="text" name="dob" id="dob"  readonly value=" <?php echo $dob ?>">
         </div>
         </div>
         <div class="form-group">
           <label class="col-sm-2 col-md-3 control-label" for="gender">Gender:</label>
           <div class="col-sm-9 col-md-5">
             <input class="form-control" type="text" name="gender" id="gender" readonly value="<?php echo $gender ?>">
           </div>
         </div>
         <div class="form-group">
           <label class="col-sm-2 col-md-3 control-label" for="postcode">Postcode:</label>
           <div class="col-sm-9 col-md-5">
             <input class="form-control" type="text" name="postcode" id="postcode" value="<?php echo $postcode ?>">
           </div>
         </div>
         <div class="form-group">
           <div class="col-sm-offset-2 col-sm-9">
             <button type="submit" class="btn btn-success" name="submit" ><i class="glyphicon glyphicon-save"></i> Save Changes</button>
           </div>
         </div>
       </fieldset>
     </form>
   </div>
  <div class="col-sm-8 col-xs-12 col-md-3" >
    <br />
    <br />
    <p>
      If you would like to delete your account and all associated data please click below
    </p>
     <form class="inline" method="post" action="myAccount.php">
       <input type="hidden" name="action" value="deleteUser">
       <input type="hidden" name="userID" value="<?php $_SESSION['currentUserID'];?>">
       <button type="submit" class="btn btn-danger">
             <i class="glyphicon glyphicon-trash"></i> Delete User Account
     </button>
     </form>
     <br />
     <p>
        <b>Warning</b> you will not be able to restore your account after it is deleted
     </p>
  </div>
  <div class="col-sm-8 col-xs-12 col-md-3" >
   <br />
   <br />
    <p>
      If you would like to delete change your password please click below
    </p>
     <a class="btn btn-warning" href="resetPassword.php"><span class="glyphicon glyphicon-edit"></span> Change Password</a>
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
