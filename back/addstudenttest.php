<?php
// this files takes studenrid,testid, quesitonid, and studentanswer 
//this takes quesitonid and students' answer stores them that they can be referenced by StudentId and TestId
$conn = new mysqli("sql2.njit.edu", "es66", "bartok58", "es66");
$studentid=$_POST["studentid"];
$questionid=$_POST["questionid"];
$studentanswer=$_POST["studentanswer"];
$testid=$_POST["testid"];
//$myquery= "SELECT Id FROM StudentTest WHERE QuestionId='".$questionid."' AND TestId='".$testid."'";
$myquery= "SELECT Id FROM StudentTest WHERE QuestionId='".$questionid."' AND TestId='".$testid."' AND StudentId='".$studentid."'";
//echo $myquery;
$result = $conn->query($myquery); 
echo $result->num_rows;
if($result->num_rows>=1)
{
	$row=$result->fetch_assoc();
	//echo $row['Id']; 
	$myquery= "UPDATE StudentTest SET StudentAnswer='".$studentanswer."' WHERE QuestionId='".$questionid."' and StudentId='".$studentid."' and TestId='".$testid."'"; 
	$conn->query($myquery); 
	echo $myquery;
}	else {
		
		$myquery = "INSERT INTO StudentTest (StudentId, TestId, QuestionId,StudentAnswer) VALUES ('".$studentid."','".$testid."','".$questionid."','".$studentanswer."')";
		$conn->query($myquery); 
	}
echo $myquery;
//myquery = "INSERT INTO StudentTest (StudentId, TestId, QuestionId,StudentAnswer) VALUES ('".$studentid."','".$testid."','".$questionid."','".$studentanswer."')";

//echo $myquery;
//$result = $conn->query($myquery); 
	$json["message"]="success";	
	echo json_encode($json); 
?> 