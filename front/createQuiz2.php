<?php
 ob_start();
    session_start();
    if(!isset($_SESSION['teacher']))header("Location: index.php");
    include('thead.php');
?>
<style>
th,td {padding:5px;}
//if {display: inline}
</style>
<script src="java.js"></script>
<?php
$dataString = 'cmd=newExam';
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL,"http://afsaccess2.njit.edu/~ls339/cs490/middle/proc.php");
curl_setopt($ch,CURLOPT_POST,true);
curl_setopt($ch,CURLOPT_POSTFIELDS, "cmd=getExamList");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$testList=curl_exec($ch);
$tests= json_decode($testList);
?>
<center>
<table><tr>
        <th>Available Quizzes</th>
    
<?php
for($i=0;$i<count($tests);$i++) {
    
    echo "<td><a href=editQuiz.php?examId=".$tests[$i]->{'Id'}." >".$tests[$i]->{'TestName'}."</a></td>";
    
}
?>
    </tr>
</table>
</center>
<?php
/* For new tests */
curl_setopt( $ch,CURLOPT_URL,"http://afsaccess2.njit.edu/~ls339/cs490/middle/proc.php");
curl_setopt($ch,CURLOPT_POST,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$dataString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$send=curl_exec($ch);
//echo $send;
//echo count($send);
$questions= json_decode($send);
//echo count($questions);
//echo $questions->{'message'};
//echo $questions;
//echo $questions->{type};
//echo "<p id=\"newExam\">test</p>";
//echo "<input type=\"button\" onInput=\"addToQuiz()\" value=\"test\">";
echo "<hr>";
echo "<center>";
echo "<form action= \"addQuiz.php\" id=\"newExamForm\" method=\"POST\">";
echo "Insert Exam Name Here<br/>";
echo "<input type=\"text\" name=\"ExamName\">";
echo "<input type=\"hidden\" name=\"cmd\" value=\"createExam\">";
echo "<input name=\"submit\" type=\"submit\" value=\"Submit\">";
echo "</form>";
echo "</center>";
echo "<hr>";

/* Filtering */
echo "<form method=\"POST\">";
echo "<select name=\"type\">";
echo "<option value=\"all\">All</option>";
echo "<option value=\"tf\">True False</option>";
echo "<option value=\"mc\">Multiple Choice</option>";
echo "<option value=\"oe\">Open Ended</option>";
echo "<select>";
echo "<select name=\"weight\">";
echo "<option value=\"all\">All</option>";
echo "<option value=\"easy\">Easy</option>";
echo "<option value=\"medium\">Medium</option>";
echo "<option value=\"hard\">Hard</option>";
//echo "<option value=\"oe\">Open Ended</option>";
echo "<select>";
echo "<input type=\"submit\" value=\"filter\">";
echo "</form>";

//if (count($questions) > 0) {
    //echo "<center><form action= \"addQuiz.php\" method=\"POST\">";
    //echo "<br/>";
    //echo "Insert Exam Name Here<br/>";
    //echo "<input type=\"text\" name=\"ExamName\">";
    //echo "<br/>";
    //echo "<input type=\"hidden\" name=\"cmd\" value=\"createExam\">";
    echo "<table border=\"1\ class=\"inlineTable\" <!--style=\"float:left-->\">";
    echo "<tr>";
    echo "<th>Select Question</th>";
    echo "<th>Question</th>";
    echo "<th>Weight</th>";
    echo "<th>Type</th>";
    echo "</tr>";
    for ($i = 0; $i < count($questions); $i++) {
        echo "<tr>";
        //echo "<td><input type=\"checkbox\" name=\"q".$i."\" value=\"".$questions[$i]->{qid}."\" ></td>";
        //echo "<td><input type=\"checkbox\" name=\"qid[]\" value=\"" . $questions[$i]->{qid} . "\" ></td>";
        echo "<td><input type=\"checkbox\" onClick=\"addToQuiz()\" name=\"qid\" id=\"qid\" value=\"" . $questions[$i]->{qid} . "\" ></td>";
        echo "<td>" . $questions[$i]->{"question"} . "<br></td>";
        echo "<td>" . $questions[$i]->{weight} . "</td>";
        echo "<td>" . $questions[$i]->{type} . "</td>";
        echo "</tr>";
    }
    echo"</table>";
    //echo "<input name=\"submit\" type=\"submit\" value=\"Submit\">";
    echo "</form></center>";
    /*
} else {
    echo "There are no Questions to make a Quiz";
}
     * 
     */

        ?>