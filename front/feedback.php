<?php
ob_start();
session_start();
if (!isset($_SESSION['student']))
    header("Location: index.php");
include('studentHeader.php');
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL,"http://afsaccess2.njit.edu/~ls339/cs490/middle/proc.php");
curl_setopt($ch,CURLOPT_POST,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$_POST);
curl_setopt($ch,CURLOPT_POSTFIELDS,"cmd=getFeedback&userId=".$_SESSION['userId']."&exam=".$_GET["exam"]);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
$send=curl_exec($ch);
//echo $send;
$feedback = json_decode($send);
/*
echo $feedback->{'ExamName'};
echo "<br>";
echo $feedback->{'NumberOfQuestions'};
echo "<br>";
 * 
 */
?>
<center><h1>Feedback for <?php echo $_GET['exam'].$_GET['score']?></h1>
           
<table border="1">
  <tr>
      <th>Question</th>
      <th>Your Answer</th>
      <th>Correct Answer</th>
      <th>Status</th>
      <th>Question Type</th>
    <th>Weight</th>
  </tr>
<?php
for($i=0;$i<$feedback->{'NumberOfQuestions'};$i++) {
    echo "<tr>";
    echo "<td>".$feedback->{'question'.$i}."</td>";
    echo "<td>".$feedback->{'youranswer'.$i}."</td>";
    echo "<td>".$feedback->{'answer'.$i}."</td>";
    //echo "<td>".$feedback->{'qtype'.$i}."</td>";
    echo "<td>".$feedback->{'qstatus'.$i}."</td>";
    //echo "<td>".$feedback->{'youranswer'.$i}."</td>";
    //echo "<td>".$feedback->{'answer'.$i}."</td>";
    //echo "<td>".$feedback->{'youranswer'.$i}."</td>";
    echo "<td>".$feedback->{'qtype'.$i}."</td>";
    echo "<td>".$feedback->{'qweight'.$i}."</td>";
    echo "</tr>";
}
?>
</table></center>

