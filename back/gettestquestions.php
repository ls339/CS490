
<?php
 // this will give the list of ID's"  ;
$conn = new mysqli("sql2.njit.edu", "es66", "bartok58", "es66"); 
$Id=$_POST["TestId"];
// has to check my get teset question the join part. 

$myquery = "SELECT Questions.Id as Id, Question FROM TestQuestions, Questions WHERE TestId='".$Id."' AND Questions.Id = QuestionId;";
$result = $conn->query($myquery); 
$json=array();

while($result2 = $result->fetch_assoc())
{
	//echo "{'questionid':'".$result2["Id"]."','question':'".$result2["Question"]."'},";
	$json[]=array('qid'=>$result2["Id"], 'question'=> $result2["Question"]);
	
}
//$json[]=array('qid'=>$result2["Id"], 'question'=> $result2["Question"]);

echo json_encode($json);
?>
