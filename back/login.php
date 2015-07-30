
<?php
$conn = new mysqli("sql2.njit.edu", "es66", "bartok58", "es66");
$user=$_POST["user"];
$password=$_POST["password"];
$myquery = "SELECT COUNT(*) as mycount, Id, Types FROM Users WHERE User='".$user."' AND Password='".$password."';";
//echo $myquery;
$result = $conn->query($myquery); 
$result = $result->fetch_assoc();
$json=array(); 

if($result['mycount'] == 0)
{
	$json["login"]="failed";
	//echo "{\"login\":\"failed\"}";
}
else
{	$json["login"]="success";
	$json["UserId"]=$result['Id'];
	$json["Type"] = $result["Types"];
	
	//echo "{\"login\":\"success\"}";
}
echo json_encode($json);
?>