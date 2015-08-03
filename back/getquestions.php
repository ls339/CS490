
<?php
//this is sending the available questions to the professor
$conn = new mysqli("sql2.njit.edu", "es66", "bartok58", "es66");
//$Id=$_POST["questionId"]; 
$myquery="SELECT * FROM Questions";
//$myquery="SELECT * FROM Questions WHERE ExamId Is NUL"";
//$myquery;
//$myquery = "SELECT * FROM QuestionAnswers WHERE QuestionId='".$Id."';";
$result = $conn->query($myquery); 
	//echo json_encode($result->fetch_assoc());
$json=array();
while($row=$result->fetch_assoc())
//while($result2 = $result->fetch_assoc()) 
{
	$json[]=$row;
	//echo "{'Answerid':'".$result2["Id"]."','answerNumber':'".$result2["AnswerNumber"]."','answer':'".$result2["Answer"]."'},";*
}
echo json_encode($json);
?>
