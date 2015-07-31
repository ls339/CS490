<?php
     ob_start();
    session_start();
    if(!isset($_SESSION['student']))header('Location: index.php');
    include('studentHeader.php');
?>
<?php

if($_POST['cmd']=='checkAnswer'){
    //echo $_POST['cmd'];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/middle/proc.php");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $check_send = curl_exec($ch);
    //echo $check_send;
    $checkAnswer = json_decode($check_send);
    //echo count($checkAnswer);
}

 $ch = curl_init();
//$testing = "cmd=takeExam&examName=".$_GET["examName"]."&username=".$_SESSION["username"]."&qid=".$_GET["qid"];
//echo $testing;
curl_setopt( $ch,CURLOPT_URL,"http://afsaccess2.njit.edu/~ls339/cs490/middle/proc.php");
curl_setopt($ch,CURLOPT_POST,true);
//curl_setopt($ch,CURLOPT_POSTFIELDS,$_POST);
curl_setopt($ch,CURLOPT_POSTFIELDS,"cmd=takeExam&examName=".$_GET["examName"]."&username=".$_SESSION["user"]."&qid=".$_GET["qid"]."&userid=".$_SESSION['userId']."&userAnswer=".$userAnswer);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
$send=curl_exec($ch);
//echo $send;
//echo "this is working";

$var = json_decode($send);
//echo count($var);
//echo $var->{question};
//echo $_SESSION['userId'];

/*if($_POST['cmd']=="checkAnswer"){
curl_setopt( $ch,CURLOPT_URL,"http://afsaccess2.njit.edu/~ls339/cs490/middle/beta/proc.php");
curl_setopt($ch,CURLOPT_POST,true);
//curl_setopt($ch,CURLOPT_POSTFIELDS,$_POST);
curl_setopt($ch,CURLOPT_POSTFIELDS,$_POST);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
$checkAnswerO=curl_exec($ch);
echo $checkAnswerO;
}*/
//echo $var->{userAnswer};
if($var->{type}=='tf'){
    echo "<b>".$var->{question}."</b>";
    //echo "TF";   
    echo "<form method= \"POST\">";
    //if($var->{userAnswer}=='True'){
    if($checkAnswer->{userAnswer}=='True'||$var->{userAnswer}=='True'){
        echo "<input type=\"radio\" name=\"Answer\" value=\"True\" checked=\"checked\">True<br>";
    }else{
        echo "<input type=\"radio\" name=\"Answer\" value=\"True\">True<br>";
    }
    //if($var->{userAnswer}=='False'){
    if($checkAnswer->{userAnswer}=='False'||$var->{userAnswer}=="False"){
        echo "<input type=\"radio\" name=\"Answer\" value=\"False\" checked=\"checked\">False<br>";
    }else{
        //echo "<input type=\"radio\" name=\"Answer\" value=\"Flase\">False<br>";
        echo "<input type=\"radio\" name=\"Answer\" value=\"False\">False<br>";
    }
    /*echo "<input type=\"radio\" name=\"Answer\" value=\"True\">True<br>";
    echo "<input type=\"radio\" name=\"Answer\" value=\"False\">False<br>";*/
    echo "<input type=\"hidden\" value=\"TF\" name=\"Type\">";
    echo "<input type=\"hidden\" value=\"checkAnswer\" name=\"cmd\">";
    echo "<input type=\"hidden\" value=\"".$var->{current}."\" name=\"current\">";
    echo "<input type=\"hidden\" value=\"".$_SESSION["user"]."\" name=\"user\">";
    echo "<input type=\"hidden\" value=\"".$_SESSION["userId"]."\" name=\"userId\">";
    echo "<input type=\"hidden\" value=\"".$_GET["examName"]."\" name=\"examName\">";
    echo "<input type=\"submit\" value=\"Save Answer\">";
    echo "</form>";
}
if($var->{type}=='mc'){
    echo "<b>".$var->{question}."</b>";
    //echo "MC";
    echo "<form method= \"POST\">";
    //if($var->{userAnswer}=='A'){
    if($checkAnswer->{userAnswer}=='A'||$var->{userAnswer}=='A'){
        echo "<input type=\"radio\" name=\"Answer\" value=\"A\" checked=\"checked\">".$var->{Opt0}."<br>";
    }else{
        echo "<input type=\"radio\" name=\"Answer\" value=\"A\">".$var->{Opt0}."<br>";
    }
    //if($var->{userAnswer}=='B'){
    if($checkAnswer->{userAnswer}=='B'||$var->{userAnswer}=='B'){
        echo "<input type=\"radio\" name=\"Answer\" value=\"B\" checked=\"checked\">".$var->{Opt1}."<br>";
    }else{
        echo "<input type=\"radio\" name=\"Answer\" value=\"B\">".$var->{Opt1}."<br>";
    }
    //if($var->{userAnswer}=='C'){
    if($checkAnswer->{userAnswer}=='C'||$var->{userAnswer}=='C'){
        echo "<input type=\"radio\" name=\"Answer\" value=\"C\" checked=\"checked\">".$var->{Opt2}."<br>";
    }else{
        echo "<input type=\"radio\" name=\"Answer\" value=\"C\">".$var->{Opt2}."<br>";
    }
    //if($var->{userAnswer}=='D'){
    if($checkAnswer->{userAnswer}=='D'){
        echo "<input type=\"radio\" name=\"Answer\" value=\"D\" checked=\"checked\">".$var->{Opt3}."<br>";
    }else{
        echo "<input type=\"radio\" name=\"Answer\" value=\"D\">".$var->{Opt3}."<br>";
    }
    /*
    echo "<input type=\"radio\" name=\"Answer\" value=\"A\">".$var->{Opt0}."<br>";
    echo "<input type=\"radio\" name=\"Answer\" value=\"B\">".$var->{Opt1}."<br>";
    echo "<input type=\"radio\" name=\"Answer\" value=\"C\">".$var->{Opt2}."<br>";
    echo "<input type=\"radio\" name=\"Answer\" value=\"D\">".$var->{Opt3}."<br>";*/
    echo "<input type=\"hidden\" value=\"MC\" name=\"Type\">";
    echo "<input type=\"hidden\" value=\"checkAnswer\" name=\"cmd\">";
    echo "<input type=\"hidden\" value=\"".$var->{current}."\" name=\"current\">";
    echo "<input type=\"hidden\" value=\"".$_SESSION["user"]."\" name=\"user\">";
    echo "<input type=\"hidden\" value=\"".$_SESSION["userId"]."\" name=\"userId\">";
    echo "<input type=\"hidden\" value=\"".$_GET["examName"]."\" name=\"examName\">";
    echo "<input type=\"submit\" value=\"Save Answer\">";
    echo "</form>";
}
if($var->{type}=='oe'){
    echo "<b>".$var->{question}."</b>";
    //echo "OE";
    echo "<form method= \"POST\">";
    //if($var->{userAnswer}!=''){
    if($checkAnswer->{userAnswer}!=''){
        //echo "<input type=\"text\" name=\"Answer\" value=\"".$var->{'userAnswer'}."\"><br>";
        echo "<input type=\"text\" name=\"Answer\" value=\"".$checkAnswer->{'userAnswer'}."\"><br>";
    }else{
        echo "<input type=\"text\" name=\"Answer\">";
    }
    //echo "<input type=\"text\" name=\"Answer\">";
    echo "<input type=\"hidden\" value=\"OE\" name=\"Type\">";
    echo "<input type=\"hidden\" value=\"checkAnswer\" name=\"cmd\">";
    echo "<input type=\"hidden\" value=\"".$var->{current}."\" name=\"current\">";
    echo "<input type=\"hidden\" value=\"".$_SESSION["user"]."\" name=\"user\">";
    echo "<input type=\"hidden\" value=\"".$_SESSION["userId"]."\" name=\"userId\">";
    echo "<input type=\"hidden\" value=\"".$_GET["examName"]."\" name=\"examName\">";
    echo "<input type=\"submit\" value=\"Save Answer\">";
    echo "</form>";
}
if($var->{previous}!=NULL){
    echo "<a href=\"takeQuiz2.php?examName=".$_GET["examName"]."&qid=".$var->{previous}."\"> previous </a>";
}
if($var->{next}!=NULL){
    echo "<a href=\"takeQuiz2.php?examName=".$_GET["examName"]."&qid=".$var->{next}."\"> next </a>";
}

?>
<form action="finalSubmit.php" method="POST">
   <input type="hidden" value="<?php echo $_GET['examName'];?>"name="examName">
   <input type="hidden" value="<?php echo $_SESSION["user"];?>"name="user">
   <input type="hidden" value="<?php echo $_SESSION["userId"];?>"name="userId">
   <input type="hidden" value="submitExam" name="cmd">
   <input type="submit" value="Submit Quiz">
</form>

