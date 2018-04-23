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
<body id="helpPage" >

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
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Help<span class="caret"></span></a>
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
  <h1>Help</h1>
  <p>Here you can get help in using the app</p>
</div>

<div id="about" class="container-fluid">
     <h2>FAQs</h2>
     <h3>Results</h3>
     <div class="panel-group">
       <div class="panel panel-default">
         <div class="panel-heading">
           <h4 class="panel-title">
             <a data-toggle="collapse" href="#collapse1">What if the category for my test isn't shown?</a>
           </h4>
         </div>
         <div id="collapse1" class="panel-collapse collapse">
           <div class="panel-body">If you have looked through all the categorys and test and you
             can't find the one you need you can request it through the request new test button
             on the input results page </div>
         </div>
       </div>
       <div class="panel panel-default">
         <div class="panel-heading">
           <h4 class="panel-title">
             <a data-toggle="collapse" href="#collapse2">What if my test isn't shown?</a>
           </h4>
         </div>
         <div id="collapse2" class="panel-collapse collapse">
           <div class="panel-body">If you have looked through all the categorys and test and you
             can't find the one you need you can request it through the request new test button
             on the input results page </div>
         </div>
       </div>
       <div class="panel panel-default">
         <div class="panel-heading">
           <h4 class="panel-title">
             <a data-toggle="collapse" href="#collapse3">What if the range for my test isn't shown?</a>
           </h4>
         </div>
         <div id="collapse3" class="panel-collapse collapse">
           <div class="panel-body">You can request it through the request new test button
             on the input results page </div>
         </div>
       </div>
       <div class="panel panel-default">
         <div class="panel-heading">
           <h4 class="panel-title">
             <a data-toggle="collapse" href="#collapse4">What I don't know what range to use?</a>
           </h4>
         </div>
         <div id="collapse4" class="panel-collapse collapse">
           <div class="panel-body">You can ask your healthcare provide which range to use, if the range isn't included
              on the list for that test, you can request it through the request new test button
                on the input results page </div>
         </div>
       </div>
     </div>
     <h3>Graphs</h3>
     <div class="panel-group">
       <div class="panel panel-default">
         <div class="panel-heading">
           <h4 class="panel-title">
             <a data-toggle="collapse" href="#collapse5">What if the test I want isn't shown?</a>
           </h4>
         </div>
         <div id="collapse5" class="panel-collapse collapse">
           <div class="panel-body">Go to the results page and make sure there is a result
              added for that test, if you think there is a problem report it using the Contact Us link </div>
         </div>
       </div>
       <div class="panel panel-default">
         <div class="panel-heading">
           <h4 class="panel-title">
             <a data-toggle="collapse" href="#collapse6">Can I save the notes graph?</a>
           </h4>
         </div>
         <div id="collapse6" class="panel-collapse collapse">
           <div class="panel-body">Unfortunatelty this isn't possible yet, but we are working on it </div>
         </div>
       </div>
       <div class="panel panel-default">
         <div class="panel-heading">
           <h4 class="panel-title">
             <a data-toggle="collapse" href="#collapse7">Why do some graphs have a green area?</a>
           </h4>
         </div>
         <div id="collapse7" class="panel-collapse collapse">
           <div class="panel-body">This green area shows the normal range for each graph and it appears when
             the graph is showing two or more results for a test </div>
         </div>
       </div>
       <div class="panel panel-default">
         <div class="panel-heading">
           <h4 class="panel-title">
             <a data-toggle="collapse" href="#collapse8">Can I see individual results on the graph?</a>
           </h4>
         </div>
         <div id="collapse8" class="panel-collapse collapse">
           <div class="panel-body">Yes you can hover over the graph to find details of individual results </div>
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
