<?php
// this will accept studentId and TestId and mark anything that meeting this criteria as release. 
$conn = new mysqli("sql2.njit.edu", "es66", "bartok58", "es66");
$studentid=$_POST["studentid"];
$testid=$_POST["testid"];

$myquery= "UPDATE TABLE StudentTest SET Released=1 WHERE StudentId='".$studentid."' and TestId='".$testid."'";
$result=$conn->query($myquery);
?>