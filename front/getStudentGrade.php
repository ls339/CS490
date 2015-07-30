<?php
    ob_start();
    session_start();
    if(!isset($_SESSION['student']))header('Location: index.html');
    include('studentHeader.php');
?>
<?php
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL,"http://afsaccess2.njit.edu/~ls339/cs490/middle/beta/proc.php");
curl_setopt($ch,CURLOPT_POST,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$_POST);
curl_setopt($ch,CURLOPT_POSTFIELDS,"cmd=getScores&username=".$_SESSION[$user]);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
$send=curl_exec($ch);
//echo $send;

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
        echo "<td>".$var[$i]->{score}."</td>";
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