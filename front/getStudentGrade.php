<?php
    ob_start();
    session_start();
    if(!isset($_SESSION['student']))header("Location: index.php");
    include('studentHeader.php');
?>
<?php

//echo $_SESSION['userId'];

$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL,"https://web.njit.edu/~ls339/cs490/middle/proc.php");
curl_setopt($ch,CURLOPT_POST,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$_POST);
curl_setopt($ch,CURLOPT_POSTFIELDS,"cmd=getScores&userId=".$_SESSION['userId']);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
$send=curl_exec($ch);
//echo $send;
//echo "cmd=getScores&userId=".$_SESSION['userId'];
$var = json_decode($send);
//echo $var;
?>
<center><table border="1">
    <tr>
        <th>Quiz Name</th>
        <th>Grade</th>
    </tr>
    <?php
    for ($i = 0; $i < count($var); $i++) {
        echo "<tr>";
        echo "<td>".$var[$i]->{exam}."</td>";
        echo "<td><a href=\"feedback.php?exam=".$var[$i]->{exam}."&score=".$var[$i]->{score}."\">".$var[$i]->{score}."<a></td>";
        //echo "<td>".$var[$i]->{score}."</td>";
        echo "</tr>";
        /*if ($var[$i]->{testingStatus} == 0) {
            echo "<form action= \"takeQuiz.php\" method= \"GET\">";
            echo "<input type=\"hidden\" name=\"examName\" value=\"" . $var[$i]->{exam} . "\">";
            echo "<input type=\"hidden\" name=\"cmd\" value=\"takeExam\">";
            //echo "<input type=\"hidden\" name=\"username\" value=\"".$_SESSION["user"]."\">";
            echo "<input type=\"submit\" name=\"submit\" value=\"Check Grade\">";
            echo "</form>";
        } else {
            echo "Already Taken";
        }*/
    }
        ?>
    </table></center>