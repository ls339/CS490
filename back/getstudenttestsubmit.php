<?php
$conn = new mysqli("sql2.njit.edu", "es66", "bartok58", "es66");
$studentid=$_POST["studentid"];
	
$myquery = "SELECT TestId FROM StudentTestSubmit WHERE UserId='".$studentid."'";
$result = $conn->query($myquery); 

$json = array();
while($result2 = $result->fetch_assoc())
{
	//echo "{'questionid':'".$result2["Id"]."','question':'".$result2["Question"]."'},";
    $json[] = array('TestId' => $result2["TestId"]);
    //$json["type"] = $result2["QuestionType"]; 
}
echo json_encode($json); 

?>