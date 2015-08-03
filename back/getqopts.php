<?php
$conn = new mysqli("sql2.njit.edu", "es66", "bartok58", "es66");
$qid=$_POST["qid"];
	
$myquery = "SELECT Answers FROM QuestionAnswers WHERE QuestionId='".$qid."'";
$result = $conn->query($myquery); 

$json = array();
while($result2 = $result->fetch_assoc())
{
	//echo "{'questionid':'".$result2["Id"]."','question':'".$result2["Question"]."'},";
    $json[] = array('Opt' => $result2["Answers"]);
    //$json["type"] = $result2["QuestionType"]; 
}
echo json_encode($json); 

?>