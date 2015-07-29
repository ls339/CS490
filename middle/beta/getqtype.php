<?php
$conn = new mysqli("sql2.njit.edu", "es66", "bartok58", "es66");
$qid=$_POST["qid"];
	
$myquery = "SELECT QuestionType FROM Questions WHERE Id='".$qid."'";
$result = $conn->query($myquery); 

$json = array();
while($result2 = $result->fetch_assoc())
{
	//echo "{'questionid':'".$result2["Id"]."','question':'".$result2["Question"]."'},";
    //$json[] = array('qid' => $result2["Id"],'question' => $result2["Question"]);
    $json["type"] = $result2["QuestionType"];
	
}

echo json_encode($json);

?>