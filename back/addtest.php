
<?php
$conn = new mysqli("sql2.njit.edu", "es66", "bartok58", "es66");
$classId=$_POST["classId"];
$usertype=$_POST["usertype"];
$testname=$_POST["testname"]; 
 
$json=array();
if($usertype == 1)
{
	$myquery = "INSERT INTO Test (ClassId, TestName) VALUES ('".$classId."','".$testname."')";
	$result = $conn->query($myquery); 
	$json["message"]="success";	
}
echo json_encode($json);
?>
