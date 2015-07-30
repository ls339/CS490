
<?php
$conn = new mysqli("sql2.njit.edu", "es66", "bartok58", "es66");
$TestId=$_POST["testId"];
$QuestionId=$_POST["questionId"];
$usertype=$_POST["usertype"];

if($usertype == 1)
{ 
	$myquery = "INSERT INTO TestQuestions (QuestionId, TestId) VALUES ('".$QuestionId."','".$TestId."')";
	$result = $conn->query($myquery); 
}

?>
