<?php
// 
$conn = new mysqli("sql2.njit.edu", "es66", "bartok58", "es66");
$studentid=$_POST["studentid"];
$testid=$_POST["testid"];

$myquery= "SELECT Id FROM StudentTest WHERE QuestionId='".$questionid."'" ;
$result = $conn->query($myquery); 
	
echo $myquery;
//myquery = "INSERT INTO StudentTest (StudentId, TestId, QuestionId,StudentAnswer) VALUES ('".$studentid."','".$testid."','".$questionid."','".$studentanswer."')";

//echo $myquesry;
//$result = $conn->query($myquery); 

	$json["message"]="success";	
	echo json_encode($json);


?>