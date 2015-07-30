
<?php
$conn = new mysqli("sql2.njit.edu", "es66", "bartok58", "es66");
$First=$_POST["first"];
$Last=$_POST["last"];
$user=$_POST["user"];
$password=$_POST["password"];
$myquery = "SELECT COUNT(*) as mycount FROM Users WHERE User='".$user."';";
//echo $myquery;
$result = $conn->query($myquery); 
$result = $result->fetch_assoc();
if($result['mycount'] == 0 && strlen($user)>3 && strlen($password)>4)
{
	$conn->query("INSERT INTO Users(First,Last,User,Password) VALUES ('".$First."','".$Last."','".$user."','".$password."');");
	$myquery2 = "SELECT COUNT(*) as mycount FROM Users WHERE User='".$user."' AND Password='".$password."';";
	//echo $myquery;
	$result2 = $conn->query($myquery2); 
	$result2 = $result2->fetch_assoc();
	if($result2['mycount'] == 1)
	{
		echo "{'signup':'success',";
		echo "'UserId':'".$result['Id']."'}";
	}
	else
	{
		echo "{'signup':'failure'}";
	}
}
else
{
	echo "{'signup':'failure'}";
}

?>
