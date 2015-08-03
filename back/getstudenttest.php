<?php
// this files accepts StudentId,TestId  
//this will return Id of each questions and the student' answer and CorrectAnswer to be compared by calling function as well the weight of the questions 
//and weather or not test is released as by teacher. 
$conn = new mysqli("sql2.njit.edu", "es66", "bartok58", "es66");
$studentid=$_POST["studentid"];
$testid=$_POST["testid"];
$json=array();
$myquery = "SELECT DISTINCT QuestionAnswers.QuestionId as Id, Released, Weight, StudentTest.StudentAnswer as StudentAnswer, QuestionAnswers.AnswerCorrect as CorrectAnswer FROM StudentTest, Questions, QuestionAnswers WHERE StudentTest.QuestionId=Questions.Id and StudentTest.QuestionId=QuestionAnswers.QuestionId and StudentTest.StudentId='".$studentid."' and StudentTest.TestId='".$testid."'";
$result = $conn->query($myquery);  
//echo "{";
while($row=$result->fetch_assoc())
{
	//echo "{'QuestionId':'".$row["Id"]."', 'released':".$row["Released"].",'weight':'".$row["Weight"]."','studentanswer':'".$row["StudentAnswer"]."','correctanswer':'".$row["CorrectAnswer"]."'}";
    $json[]=array('QuestionId' => $row["Id"], 'released' => $row["Released"], 'weight' => $row["Weight"], 'studentanswer' => $row["StudentAnswer"], 'correctanswer' => $row["CorrectAnswer"]);
} 
echo json_encode($json); 
?>  
 
 