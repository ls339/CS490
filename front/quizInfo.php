<?php
 ob_start();
    session_start();
    if(!isset($_SESSION['teacher']))header("Location: index.php");
    include('thead.php');
?>
<?php

$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL,"https://web.njit.edu/~ls339/cs490/middle/proc.php");
curl_setopt($ch,CURLOPT_POST,true);
curl_setopt($ch,CURLOPT_POSTFIELDS, "cmd=examInfo&examId=".$_GET['examId']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$send=curl_exec($ch);
$quizInfo = json_decode($send);

echo "<center>";
echo "<table><tr><th>".$quizInfo[0]."</th></tr></table>";
echo "<table>";
//echo "<caption align=\"top\">".$quizInfo[0]."</caption>";
echo "<tr>";
echo "<th>Question</th>";
echo "<th>Answer</th>";
echo "<th>Type</th>";
echo "<th>Weight</th>";
echo "</tr>";
for($i=1;$i<count($quizInfo);$i++) {
    echo "<tr>";
    echo "<td>".$quizInfo[$i]->{'question'}."</td>";
    echo "<td>".$quizInfo[$i]->{'answer'}."</td>";
    echo "<td>".$quizInfo[$i]->{'type'}."</td>";
    echo "<td>".$quizInfo[$i]->{'weight'}."</td>";
    echo "</tr>";
}
echo "</table>";
echo "</center>";
?>
