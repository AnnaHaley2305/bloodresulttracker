<?php

include ("resources/dbConnect.php");

session_start();
$userID = $_SESSION['currentUserID'];
$testID = $_POST['id'];

$dbQuery = $db->prepare("select gender, age from userInfo where userID=:userID");
$dbParams = array('userID'=>$userID);
$dbQuery->execute($dbParams);
if($dbQuery)
{
	while ($dbRow=$dbQuery->fetch(PDO::FETCH_ASSOC)) {
		$gender = $dbRow['gender'];
		$age = $dbRow['age'];
	}

	$dbQuery2 = $db->prepare("select * from ranges where testID=:testID and :age between startAge and endAge order by lowRange asc");
	$dbParams2 = array('testID'=>$testID, 'age'=>$age);
	$dbQuery2->execute($dbParams2);
	if($dbQuery)
	{
		 while ($dbRow=$dbQuery2->fetch(PDO::FETCH_ASSOC)) {
			 $rangeID = $dbRow['rangeID'];
			 $lowRange = $dbRow['lowRange'];
			 $highRange = $dbRow['highRange'];
			 $rangeGender = $dbRow['gender'];
			 $range = $lowRange." - ".$highRange;
			 if ($rangeGender == "B")
			 {
			 	$rangeArray[] = array("id" => $rangeID, "name" => $range);
			 }
			 elseif ($rangeGender == $gender)
			 {
			 	$rangeArray[] = array("id" => $rangeID, "name" => $range);
			 }
		}

		echo json_encode($rangeArray);
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
	$message = "Oops, Something went wrong! Error";
	$errors = $dbQuery->errorInfo();
	$userError = $errors[2];
	echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
	header("Location: inputResults.php");
}
?>
