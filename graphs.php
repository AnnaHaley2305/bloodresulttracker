<?php   include ("dbConnect.php");

	session_start();
  if (!isset($_SESSION['currentUserID']))
  {
	 header("Location: login.php");
  }

  	  $timeline="false";
  	  $quality="false";
	  if (isset($_POST["test"])) {
			$testID=$_POST["test"];
			$userID=$_SESSION["currentUserID"];
			$dbQuery=$db->prepare("select * from results, ranges where results.userID=:userID and results.testID=:testID and ranges.rangeID = results.rangeID order by date asc");
			$dbParams = array('userID'=>$userID, 'testID'=>$testID);
			$dbQuery->execute($dbParams);
			if($dbQuery)
			{

				$dbQuery2=$db->prepare("select * from tests where testID=:testID");
				$dbParams2 = array('testID'=>$testID);
				$dbQuery2->execute($dbParams2);
				if($dbQuery2)
				{
					if ($dbQuery->rowCount()>0)
				  	{
						$timeline="true";
						if ($dbQuery->rowCount()>1)
						{
							$quality="true";
						}
						while($dbRow =$dbQuery2->fetch(PDO::FETCH_ASSOC)) {
							$testName=$dbRow['testName'];
						}
						$results = array(
							'cols' => array (
								array('label' => 'Date', 'type' => 'date'),
								array('label' => 'Lower Range', 'type' => 'number'),
								array('label' => 'Lower Range', 'type' => 'number',),
								array('label' => 'Range', 'type' => 'number'),
								array('label' => 'Upper Range', 'type' => 'number',),
							   array('label' => $testName, 'type' => 'number')
							),//graph column label and types
							'rows' => array()
						);// array for row data
						while($dbRow =$dbQuery->fetch(PDO::FETCH_ASSOC)) {
							$dateArr = explode('-', $dbRow['date']);
							$year = (int) $dateArr[0];
							$month = (int) $dateArr[1] - 1;
							$day = (int) $dateArr[2];
							$boundary = $dbRow['highRange']-$dbRow['lowRange'];
						//splits the date into year month and day for json format
							$results['rows'][] = array('c' => array(
								array('v' => "Date($year, $month, $day)"),
								array('v' => $dbRow['lowRange']),
								array('v' => $dbRow['lowRange']),
								array('v' => $boundary),
								array('v' => $dbRow['highRange']),
								array('v' => $dbRow['result'])
								//add dates and results to the row array
									));
								}
								$json_timeline = json_encode($results);
							}
						else{
							$timeline="false";
						}
				}
				else {
					$message = "Oops, Something went wrong! Error";
		 			$errors = $dbQuery2->errorInfo();
		 			$userError = $errors[2];
		 			echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
		 			header("Location: graphs.php");
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

		}
		else
		{
			$timeline="false";
		}

		//encode the results to json format
		$note="false";
		$userID=$_SESSION["currentUserID"];
		$dbQuery3=$db->prepare("select * from notes where userID=:userID order by startDate asc");
		$dbParams3 = array('userID'=>$userID);
		$dbQuery3->execute($dbParams3);
		if($dbQuery3)
		{
			if ($dbQuery3->rowCount()>0)
			{

				$note="true";
				$notes = array(
					'cols' => array (
						array('label' => 'Note', 'type' => 'string'),
						array('label' => 'Start Date', 'type' => 'date'),
						array('label' => 'End Date', 'type' => 'date')
					),//graph column label and types
					'rows' => array()
				);// array for row data

				while($dbRow =$dbQuery3->fetch(PDO::FETCH_ASSOC)) {
					$startDateArr = explode('-', $dbRow['startDate']);
					$startYear = (int) $startDateArr[0];
					$startMonth = (int) $startDateArr[1] - 1;
					$startDay = (int) $startDateArr[2];
					$endDateArr = explode('-', $dbRow['endDate']);
					$endYear = (int) $endDateArr[0];
					$endMonth = (int) $endDateArr[1] - 1;
					$endDay = (int) $endDateArr[2];
				//splits the date into year month and day for json format
					$notes['rows'][] = array('c' => array(
						array('v' => $dbRow['noteName']),
						array('v' => "Date($startYear, $startMonth, $startDay)"),
						array('v' => "Date($endYear, $endMonth, $endDay)")
						//add dates and results to the row array
					));
				}
				$json_note = json_encode($notes);//encode the results to json format
			}
			else{
				$note="false";
			}
		}
		else
		{
			$message = "Oops, Something went wrong! Error";
			$errors = $dbQuery3->errorInfo();
			$userError = $errors[2];
			echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
			header("Location: graphs.php");
		}

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
  <script type="text/javascript">

  		  google.charts.load('current', {'packages':['corechart','controls', 'timeline']});

		  google.charts.setOnLoadCallback(drawLineChart);
		  google.charts.setOnLoadCallback(drawNoteChart);

		 function drawLineChart() {
  		 var data = new google.visualization.DataTable(<?=$json_timeline?>);//retrieves the php data
		 var rangeFilter = new google.visualization.ControlWrapper({
			  controlType: 'DateRangeFilter',
					containerId: 'control_timeline',
					options: {
					// Filter by the date axis.
					filterColumnIndex: 0,
						 ui: {
									step: 'day',
									format: 'M/d/yy',
									labelStacking: 'vertical',
								 	label: 'Timeline :',
							 },
						chartView: {
							 columns: [0]
						 }
					}
		 });

      var chart = new google.visualization.ChartWrapper({
          chartType: 'ComboChart',
          containerId: 'timeline',
          options: {
              // width and chartArea.width should be the same for the filter and chart
            legend: {position: 'bottom'},
				isStacked: true,
  				height: 400,
            width: '100%',
            chartArea: {
               width: '100%',
					left:40,
  					top:5,
            },
  				colors: ['#C8A2C8'],// line colour
  				animation: {
  					duration: 500,
  					startup: true //This is the new option
  				},
				series: {
						0: {	type: 'area', color: 'transparent',	visibleInLegend: 'false'},
						1: {	type: 'line', color: '#00FF00', visibleInLegend: 'false' },
						2: { type: 'area', color: '#DDF3CA', labelInLegend: 'Normal Range'},
						3: { type: 'line', color: '#00FF00', visibleInLegend: 'false' },
						4: {	type: 'line', color: '#C8A2C8'},
					}
          }
      });

      // Create the dashboard
      var dash = new google.visualization.Dashboard(document.getElementById('dashboard_timeline'));
      // bind the chart to the filter

		google.visualization.events.addListener(chart, 'ready', function () {
		var div = document.getElementById('timelinePng');
		div.innerHTML = "";
		var link = document.createElement("a");
		var imgURI = chart.getChart().getImageURI();
		link.href = imgURI;
		link.classList.add("btn");
		link.classList.add("btn-success");
		link.download = "image.png";
		link.innerHTML = '<span class="glyphicon glyphicon-save"></span> Download Graph';
		div.append(link);

	});

      dash.bind([rangeFilter], [chart]);
		dash.draw(data);

		$(document).ready(function () {
		$(window).resize(function() {  // reference dashboard instance
         dash.draw(data);
 			});
			});
  		}

		 function drawNoteChart() {
			 var data = new google.visualization.DataTable(<?=$json_note?>);//retrieves the php data
			 var dashboard = new google.visualization.Dashboard(
                document.getElementById('dashboard_note'));
                var control = new google.visualization.ControlWrapper({
                    controlType: 'DateRangeFilter',
                        containerId: 'control_note',
                        options: {
                        // Filter by the date axis.
								filterColumnIndex: 1,
								filterColumnLabel: 'Date',
               			ui: {
									labelStacking: 'vertical',
								 	label: 'Timeline :',
									format: 'MM/yy'}
          					}
                });

                var chart = new google.visualization.ChartWrapper({
                    chartType: 'Timeline',
                        containerId: 'note',
                        options: {
                        	 width: '100%',
                            height: '100%',
                            chartArea: {
                            		width: '100%',
                            		height: '100%'
                        	},
								 timeline: { groupByRowLabel: false }
                    },
                        view: {
                        	columns: [0, 1, 2]
                    }

                });
					 dashboard.bind([control], [chart]);

					 dashboard.draw(data);

					 $(document).ready(function () {
					 $(window).resize(function() {  // reference dashboard instance
			          dashboard.draw(data);
			  		});

	    });
	 }

	 </script>
</head>
<body id="graphPage" >

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
		  <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"> My Results <span class="caret"></span></a>
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
  <h1>My Graphs</h1>
  <p>Here you can view your graphs</p>
</div>

	  <?php
			$dbQuery2=$db->prepare("select * from results, tests where results.userID=:userID and tests.testID=results.testID");
			$dbParams2 = array('userID'=>$userID);
			$dbQuery2->execute($dbParams2);
			if($dbQuery2)
			{
				$tests=[];
				while($dbRow=$dbQuery2->fetch(PDO::FETCH_ASSOC))
				{
					$testName=$dbRow["testName"];
					$testID=$dbRow["testID"];

					if (!in_array($testID, $tests))
					{
						$tests[$testID] = $testName;
					}
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

<script type="text/javascript">

$(document).ready(function () {
	var timeline =<?php echo $timeline; ?>;
	var note =<?php echo $note;?>;
	var quality =<?php echo $quality;?>;

	if (timeline==true) {
   	$("#timelineDiv").show();
		if (quality==false)
		{
			$("#qualityDiv").show();
		}
		else {
			$("#qualityDiv").hide();
		}
   } else {
		$("#timelineDiv").hide();
	}
	if(note==true) {
		$("#noteDiv").show();
		$("#noNotes").hide();
	} else {
		$("#noteDiv").hide();
		$("#noNotes").show();
	}
	if(timeline==true && note==true)
	{
		$("#header1").show();
		$("#header2").hide();
		$("#header3").hide();
	}
	else if(timeline==false && note==false)
	{
		$("#header1").hide();
		$("#header2").hide();
		$("#header3").show();
	}
	else {
		$("#header1").hide();
		$("#header2").show();
		$("#header3").hide()
	}

});

</script>


<div class="container-fluid">
	<div class="row">
		<h3 id="header1"> Choose a different test to see more results </h3>
		<h3 id="header2"> Choose a test to see some results </h3>
		<div id="header3"> <h3>Let's add some tests or notes to get started! </h3>
			<a class="btn btn-success" href="inputResults.php">
			<span class="glyphicon glyphicon-edit"></span> Add More Notes</a>
			<a class="btn btn-success" href="inputResults.php">
			<span class="glyphicon glyphicon-edit"></span> Add More Results</a>
		</div>
	</div>
	<div class="row" >
		<form class="form-horizontal col-xs-12" role="form" method="post" action="graphs.php" id="testForm">
			<fieldset>
			<div class="form-group">
			  <label class="col-md-1 col-lg-1 col-sm-2 col-xs-3 control-label text-center" for="test">Tests :</label>
			  <div class="col-sm-6 col-md-4 col-lg-4 col-xs-6">
						 <select class="form-control" id="test" name="test">
								<?php foreach ($tests as $testID => $testName)
								{
									echo '<option value="'. $testID .'">'. $testName .'</option>';
								}?>
					  </select>
			  </div>
			 <button type="submit" name="submit"class="btn btn-success">Submit</button>
			</div>
		 </fieldset>
	  </form>
	  <p>Choose a test from the list and press submit</p>
	  </div>
	<div class="row" id="timelineDiv">
	<h1>Timeline</h1>
	 <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
		 <p>Here you can view a timeline of your results for each test.</p>
		 <p>The green lines show the normal range for each test and the purple line shows your results.</p>
		 <div id="dashboard_timeline" class="embed-responsive-item">
			<div id="timeline" class="embed-responsive-item"></div>
			<div id="control_timeline" class="embed-repsonsive-item"></div>
		</div>
		<p> You can change the time period on the graph using this slider</p>
	  </div>
	  <div class="col-lg-1 col-md-2 col-sm-12 col-xs-12" id="qualityDiv">
		  <h2 class="alert alert-info"> Looks like you only have one result for this test,
			  the timeline feature works best with more than one result!
			  If you would like to add another result click below.
		  </h2>
			<a class="btn btn-success" href="inputResults.php">
				<span class="glyphicon glyphicon-edit"></span> Add More Results</a>
	 </div>
	  <div class="col-lg-1 col-md-2 col-sm-12 col-xs-12">
		  <br />
		  <p>	This will download and save a picture of the timeline graph to your computer as it looks now </p>
		<div id="timelinePng"></div>
	 </div>
</div>

<div class="row" id="noteDiv">
	<h1>Notes</h1>
	<p>This is a timeline of the notes you have made</p>
	 <div class="col-lg-10 col-sm-12 col-xs-12">
		 <div id="dashboard_note" class="embed-responsive-item">
			<div id="note" class="embed-responsive-item"></div>
			<div id="control_note" class="embed-repsonsive-item"></div>
	  </div>
	 </div>
	 <p> You can change the time period for the notes shown using this slider</p>
</div>
<div class="row" id="noNotes">
	<h2 class="alert alert-warning">Looks like you don't have any notes to display yet,
	to add some notes please click below!</h2>
	<a class="btn btn-success" href="inputResults.php">
	<span class="glyphicon glyphicon-edit"></span> Add More Notes</a>
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
