
<?php
// teacher can get the student test. 

$conn = new mysqli("sql2.njit.edu", "es66", "bartok58", "es66");
$Id=$_POST["classId"];
//add variable  
	
$myquery = "SELECT * FROM Test"; 
$result = $conn->query($myquery);
$json=array(); 

while($result2 = $result->fetch_assoc())
{
	//echo "test";
//echo "{'testid':'".$result2["Id"]."','testname':'".$result2["TestName"]."'},"; 
	//$json["Id"]=$result2["Id"];
	//$json["testname"]=$result2["TestName"];
	$json[]=array('Id'=>$result2["Id"], 'TestName'=> $result2["TestName"]);
}
//echo "}"; 
echo json_encode($json);  

?>
