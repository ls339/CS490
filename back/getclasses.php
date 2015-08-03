  
<?php
$conn = new mysqli("sql2.njit.edu", "es66", "bartok58", "es66");
$Id=$_POST["userId"];
	
$myquery = "SELECT Classes.Id as myclassid, Classes.ClassName as myclassname FROM StudentClasses, Classes WHERE StudentId='".$Id."' AND ClassId = Classes.Id;";
$result = $conn->query($myquery); 
echo  "{";
while($result2 = $result->fetch_assoc())
{
	echo "{'classid':'".$result2["myclassid"]."','classname':'".$result2["myclassname"]."'},";
}
echo "}"; 
?>
