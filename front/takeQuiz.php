<?php
     ob_start();
    session_start();
    if(!isset($_SESSION['student']))header('Location: index.html');
    include('studentHeader.php');
?>
<?php
 $ch = curl_init();
$testing = "cmd=takeExam&examName=".$_GET["examName"]."&username=".$_SESSION["username"]."&qid=".$_GET["qid"];
//echo $testing;
curl_setopt( $ch,CURLOPT_URL,"http://afsaccess2.njit.edu/~ls339/cs490/middle/beta/proc.php");
curl_setopt($ch,CURLOPT_POST,true);
//curl_setopt($ch,CURLOPT_POSTFIELDS,$_POST);
curl_setopt($ch,CURLOPT_POSTFIELDS,"cmd=takeExam&examName=".$_GET["examName"]."&username=".$_SESSION["user"]."&qid=".$_GET["qid"]);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
$send=curl_exec($ch);
//echo $send;
//echo "this is working";

$var = json_decode($send);
//echo count($var);
//echo $var->{question};

if($var->{type}=='tf'){
    echo $var->{question};
    //echo "TF";
    echo "<form method= \"POST\">";
    echo "<input type=\"radio\" name=\"Answer\" value=\"True\">True<br>";
    echo "<input type=\"radio\" name=\"Answer\" value=\"False\">False<br>";
    echo "<input type=\"hidden\" value=\"TF\" name=\"Type\">";
    echo "<input type=\"hidden\" value=\"checkAnswer\" name=\"cmd\">";
    echo "<input type=\"hidden\" value=\"".$var->{current}."\" name=\"current\">";
    echo "<input type=\"hidden\" value=\"".$_SESSION["user"]."\" name=\"user\">";
    echo "<input type=\"submit\" value=\"Save Answer\">";
    echo "</form>";
}
if($var->{type}=='mc'){
    echo $var->{question};
    //echo "MC";
    echo "<form method= \"POST\">";
    echo "<input type=\"radio\" name=\"Answer\" value=\"A\">".$var->{Opt1}."<br>";
    echo "<input type=\"radio\" name=\"Answer\" value=\"B\">".$var->{Opt2}."<br>";
    echo "<input type=\"radio\" name=\"Answer\" value=\"C\">".$var->{Opt3}."<br>";
    echo "<input type=\"radio\" name=\"Answer\" value=\"D\">".$var->{Opt4}."<br>";
    echo "<input type=\"hidden\" value=\"MC\" name=\"Type\">";
    echo "<input type=\"hidden\" value=\"checkAnswer\" name=\"cmd\">";
    echo "<input type=\"hidden\" value=\"".$var->{current}."\" name=\"current\">";
    echo "<input type=\"hidden\" value=\"".$_SESSION["user"]."\" name=\"user\">";
    echo "<input type=\"submit\" value=\"Save Answer\">";
    echo "</form>";
}
if($var->{type}=='oe'){
    echo $var->{question};
    //echo "OE";
    echo "<form method= \"POST\">";
    echo "<input type=\"text\" name=\"Answer\">";
    echo "<input type=\"hidden\" value=\"TF\" name=\"Type\">";
    echo "<input type=\"hidden\" value=\"checkAnswer\" name=\"cmd\">";
    echo "<input type=\"hidden\" value=\"".$var->{current}."\" name=\"current\">";
    echo "<input type=\"hidden\" value=\"".$_SESSION["user"]."\" name=\"user\">";
    echo "<input type=\"submit\" value=\"Save Answer\">";
    echo "</form>";
}
if($var->{previous}!=NULL){
    echo "<a href=\"takeQuiz.php?examName=".$_GET["examName"]."&qid=".$var->{previous}."\"> previous </a>";
}
if($var->{next}!=NULL){
    echo "<a href=\"takeQuiz.php?examName=".$_GET["examName"]."&qid=".$var->{next}."\"> next </a>";
}
if($_POST['cmd']=='checkAnswer'){
    //echo $_POST['Answer'];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/middle/beta/proc.php");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $send = curl_exec($ch);
    //echo $send;
}

?>
<form action="finalSubmit.php" method="POST">
   <input type="hidden" value="<?php echo $_GET['examName'];?>" name="examName">
   <input type="hidden" value="<?php echo $_SESSION["user"];?> " name=user>
   <input type="hidden" value="submitExam" name="cmd">
   <input type="submit" value="Submit Quiz">
</form>

