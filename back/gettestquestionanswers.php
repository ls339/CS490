
<?php
$conn = new mysqli("sql2.njit.edu", "es66", "bartok58", "es66");
$Id=$_POST["questionId"];
$myquery = "SELECT * FROM QuestionAnswers WHERE QuestionId='".$Id."';";
//echo $myquery;
$result = $conn->query($myquery);
$json=array(); 
while($result2 = $result->fetch_assoc())
{
	//echo "lewis";
	//echo "{'Answerid':'".$result2["Id"]."','answerNumber':'".$result2["AnswerNumber"]."','answer':'".$result2["Answer"]."'},";
	$json[]=array('Answerid'=>$result2["Id"], 'answerNumber'=> $result2["AnswerNumber"],'answers'=> $result2["Answer"],'answersCorrect'=> $result2["AnswerCorrect"]);	
}
echo json_encode($json); 

?>