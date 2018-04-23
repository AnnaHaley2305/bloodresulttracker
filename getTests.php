<?php

include ("dbConnect.php");

$categoryID = $_POST['id'];   // idment id

$dbQuery2 = $db->prepare("select * from tests where categoryID=:categoryID");
$dbParams2 = array('categoryID'=>$categoryID);
$dbQuery2->execute($dbParams2);
if($dbQuery2)
{
   $testArray = array();
    while ($dbRow=$dbQuery2->fetch(PDO::FETCH_ASSOC)) {
   	 $testID = $dbRow['testID'];
   	 $testName = $dbRow['testName'];
   	 $testArray[] = array("id" => $testID, "name" => $testName);
   }

   // encoding array to json format
   echo json_encode($testArray);
}
else {
   $message = "Oops, Something went wrong! Error";
   $errors = $dbQuery2->errorInfo();
   $userError = $errors[2];
   echo "<script type='text/javascript'>alert('$message.' '.$userError');</script>";
   header("Location: graphs.php");
}
?>
