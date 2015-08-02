<?php
$conn = new mysqli("sql2.njit.edu", "es66", "bartok58", "es66");
$userid=$_POST["userid"];
$testid=$_POST["testid"];	
$myquery = "SELECT * FROM StudentTestSubmit WHERE UserId='".$userid."' AND TestId='".$testid."'";
$result = $conn->query($myquery); 

$json = array();
while($result2 = $result->fetch_assoc())
{
	//echo "{'questionid':'".$result2["Id"]."','question':'".$result2["Question"]."'},";
    //$json[] = array('UserId' => $result2["UserId"],'TestId' => $result2["TestId"],'Submitted' => $result2["Submitted"],'ScoreRelease' => $result2["ScoreRelease"]);
    //$json["question"] = $result2["Question"];
    $json['UserId'] = $result2["UserId"];
    $json['TestId'] = $result2["TestId"];
    $json['Submitted'] = $result2["Submitted"];
    $json['ScoreRelease'] = $result2["ScoreRelease"];
	
}

echo json_encode($json);

?>