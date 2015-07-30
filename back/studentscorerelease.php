<?php
// 


$conn = new mysqli("sql2.njit.edu", "es66", "bartok58", "es66");
$studentid=$_POST["studentid"];
$testid=$_POST["testid"];

//$myquery= "UPDATE StudentTestSubmit (ScoreRelease) VALUES ('1') WHERE UserId='".$studentid."' and TestId='".$testid."'";
$myquery = "UPDATE StudentTestSubmit SET ScoreRelease='1' WHERE UserId='".$studentid."' and TestId='".$testid."'";
$result = $conn->query($myquery); 
	
echo $myquery;
	$json["message"]="success";	
	echo json_encode($json);

?>