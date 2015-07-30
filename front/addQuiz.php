<?php
$post=array();
$qid=array();
for($i=0; $i<count($_POST['qid']);$i++){
    $post['q'.$i]=$_POST['qid'][$i];
}
//echo count($qid);
$post['ExamName']=$_POST['ExamName'];
$post['cmd']=$_POST['cmd'];
$post['qid']=$qid;
$ch = curl_init();
//echo count($_POST['qid']);
/*echo $_POST["ExamName"];
echo $_POST["cmd"];
echo $_POST["submit"];
echo $_POST['qid'][0];
echo $_POST['qid'][1];*/
//$qid ="qid[]";
//$add ="cmd=createExam&ExamName=".$_POST['ExamName']."&qid=".$_POST['qid'];
curl_setopt( $ch,CURLOPT_URL,"http://afsaccess2.njit.edu/~ls339/cs490/middle/beta/proc.php");
curl_setopt($ch,CURLOPT_POST,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$post);
//curl_setopt($ch,CURLOPT_HTTPHEADER,array("Content-type: multipart/form-data"));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$send=curl_exec($ch);
echo $send;
$var= json_decode($send);
//echo print_r($_POST['qid']);
if($var->{'status'}=='ok'){
    header('Location: createQuiz.php');
}else{
    echo "Contact admin for more help";
}
?>

