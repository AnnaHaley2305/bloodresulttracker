<?php
   include ("resources/dbConnect.php");
   session_start();
   if (!isset($_SESSION['currentUserID']))
   {
     header("Location: login.php");
   }

   if (isset($_POST["action"]) && $_POST["action"]=="deleteResults") {
     $dbQuery=$db->prepare("delete from results where resultID=:id");
     $dbParams = array('id'=>$_POST["resultID"]);
     $dbQuery->execute($dbParams);
     if($dbQuery)
     {
        $message = "Successfully Deleted";
        echo "<script type='text/javascript'>alert('$message');</script>";
     }
     else
     {
        $message = "Oops, Something went wrong! Error";
        $errors = $dbQuery->errorInfo();
        $userError = $errors[2];
        echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
        header("Location: results.php");

     }


   }
   if (isset($_POST["action"]) && $_POST["action"]=="archive") {
     $dbQuery=$db->prepare("insert into archive select null, userID, testID, rangeID, result, date, outcome, comments from results where resultID=:id");
     $dbParams = array('id'=>$_POST["resultID"]);
     $dbQuery->execute($dbParams);
     if($dbQuery)
     {
        $dbQuery2=$db->prepare("delete from results where resultID=:id");
        $dbParams2 = array('id'=>$_POST["resultID"]);
        $dbQuery2->execute($dbParams2);
        if($dbQuery2)
        {
           $message = "Successfully Archived";
           echo "<script type='text/javascript'>alert('$message');</script>";
        }
        else {
         $message = "Oops, Something went wrong! Error";
         $errors = $dbQuery2->errorInfo();
         $userError = $errors[2];
         echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
         header("Location: results.php");

       }
     }
     else {
       $message = "Oops, Something went wrong! Error";
       $errors = $dbQuery->errorInfo();
       $userError = $errors[2];
       echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
       header("Location: results.php");

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
  <link rel="icon" href="img/heart-beat-icon.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js "></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
</head>
<body id="resultsPage" >

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
  <h1>My Results</h1>
  <p>Here you can view and edit your blood results</p>
</div>
<script>
$(document).ready(function() {
    $('#tableData').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copy',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                },
                className: 'btn btn-success',
                text: '<span class="glyphicon glyphicon-copy"></span> Copy'
            },
            {
                extend: 'excel',
                exportOptions: {
                     columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                },
                className: 'btn btn-success',
                text: '<span class="glyphicon glyphicon-th-list"></span> Save as Excel'
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                },
                className: 'btn btn-success',
                text: '<span class="glyphicon glyphicon-save-file"></span> Save as PDF',
            }
        ],
        paging: false
    } );
$('.dt-buttons').addClass('col-lg-6 col-md-6 col-sm-12 col-xs-12');
$('.dataTables_filter').addClass('col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right');
$('.dataTables_filter input').addClass('form-control');
} );
</script>

<div class="container-fluid container-body">
   <div class="row">
   	<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12" >
       <div class="table-responsive">
       	<?php
       				$user=$_SESSION["currentUserID"];
       				$dbQuery=$db->prepare("select category.category, tests.testName, tests.unit, results.*
                      from category, tests, results where (results.userID=:userID) AND (results.testID=tests.testID)
                      and (category.categoryID=tests.categoryID) order by results.date desc");
                  $dbParams = array('userID'=>$user);
       				$dbQuery->execute($dbParams);
                  if($dbQuery){
          		     ?>



                    <?php if ($dbQuery->rowCount()>0)
                    {
                       ?>
                       <p> This is where your blood results are stored, you can delete or achive any results using the buttons</p>
                       <p> <b>Warning!</b> If you delete any results you cannot get them back again </p>
                       <p> You can restore your results from the archive at any time </p>
                       <p> You can search through your results using the search box below</p>
                       <table class ="table table-hover table-condensed table-bordered" style="padding: 0px" id="tableData">
                        <thead>
                        <tr>
                           <th>Category</th>
                           <th>Test</th>
                           <th>Result</th>
                           <th>Unit</th>
                           <th>Date</th>
                           <th>Outcome</th>
                           <th>Comments</th>
                           <th>Delete</th>
                           <th>Archive</th>
                       </tr></thead>
                       <tbody id="resultsTable">
                       <?php
                       while ($dbRow=$dbQuery->fetch(PDO::FETCH_ASSOC)) {
                          ?>
                           <tr>
                             <td> <?php echo $dbRow["category"];?></td>
                			     <td> <?php echo $dbRow["testName"];?></td>
                             <td> <?php echo $dbRow["result"]?></td>
                			     <td> <?php echo $dbRow["unit"];?></td>
                			     <td> <?php echo $dbRow["date"];?></td>
                			     <td> <?php echo $dbRow["outcome"];?></td>
                   			  <td> <?php echo $dbRow["comments"]?></td>
                             <td>
                               <form class="text-center" method="post" action="results.php">
                                  <input type="hidden" name="action" value="deleteResults">
                                  <input type="hidden" name="resultID" value="<?php echo $dbRow['resultID'];?>">
                                  <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?');">
                                       <i class="glyphicon glyphicon-trash" ></i> Delete
                                 </button>
                               </form>
                            </td>
                            <td>
                              <form class="text-center" method="post" action="results.php">
                                 <input type="hidden" name="action" value="archive">
                                 <input type="hidden" name="resultID" value="<?php echo $dbRow['resultID'];?>">
                                 <button type="submit" class="btn btn-warning">
                                      <i class="glyphicon glyphicon-share"></i> Archive
                                </button>
                              </form>
                           </td>

                			  </tr>
                        <?php
                        }

                     }
                        else{
                           echo '<div class="alert alert-info"><h3>Looks like you don\'t have any results to display yet</h3></div>';
                        }
                  }
                  else {
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
    <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4" >
      <p> If you would like to add results, please click below </p>
       <a class="btn btn-success" href="inputResults.php"><span class="glyphicon glyphicon-edit"></span> Add More Results</a>
    </div>
    <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4" >
      <p> If you would like to view the archive, please click below </p>
       <a class="btn btn-info" href="archive.php"><span class="glyphicon glyphicon-new-window"></span> View the Archive</a>
	</div>
   <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4" >
     <p> If you would like to a view the graphs, please click below </p>
      <a class="btn btn-info" href="graphs.php"><span class="glyphicon glyphicon-new-window"></span> View Graphs </a>
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
      <a href="mailto:admin@mybloodresulttracker.co.uk?Subject=Contact%20Us">Contact Us</a>
      <p>&copy; 2018</p>
  </div>
</footer>
</body>
</html>
