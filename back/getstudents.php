<?php
$conn = new mysqli("sql2.njit.edu", "es66", "bartok58", "es66");
$qid=$_POST["qid"];
	
$myquery = "SELECT Id,First,Last,User,Email FROM Users WHERE Types='0'";
$result = $conn->query($myquery); 

$json = array();
while($result2 = $result->fetch_assoc())
{
	//echo "{'questionid':'".$result2["Id"]."','question':'".$result2["Question"]."'},";
    $json[] = array('UserName' => $result2["User"],'FirstName' => $result2["First"],'LastName' => $result2["Last"],'UserId' => $result2["Id"],'Email' => $result2["Email"]);
    //$json["type"] = $result2["QuestionType"];
	
}

echo json_encode($json);

?>