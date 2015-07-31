<?php
     ob_start();
    session_start();
    if(!isset($_SESSION['teacher']))header('Location: index.php');
    include('thead.php');
?>
    <?php
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/middle/proc.php");
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=examScores");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $send = curl_exec($ch);
  //echo $send;
  
  $var = json_decode($send);
  //echo count($var);
  
  ?>

<center><table border="1">
  <tr>
    <th>Name</th>
    <th>Exam</th> 
    <th>Score</th>
    <th>Release Grades</th>
  </tr>
  <?php
    for ($i = 0; $i < count($var); $i++) {
      echo "<tr>";
      echo "<td>".$var[$i]->{name}."</td>";
      echo "<td>".$var[$i]->{exam}."</td>";
      echo "<td>".$var[$i]->{score}."</td>";
      echo "<td>";
      if($var[$i]->{releaseStatus}==0){
          echo "<form action= \"realeaseGrades.php\" method= \"POST\">";
          echo "<input type=\"hidden\" name=\"studentId\" value=\"".$var[$i]->{studentId}."\">";
          echo "<input type=\"hidden\" name=\"user\" value=\"".$var[$i]->{name}."\">";
          echo "<input type=\"hidden\" name=\"examName\" value=\"".$var[$i]->{exam}."\">";
          echo "<input type=\"hidden\" name=\"examId\" value=\"".$var[$i]->{examId}."\">";
          echo "<input type=\"hidden\" name=\"cmd\" value=\"releaseScore\">";
          echo "<input type=\"submit\" name=\"submit\" value=\"Release Score\">";
          echo "</form>";
      }else{
          echo "Already Released";
      }
      echo "</td></tr>";
  }
  ?>
    </table></center>