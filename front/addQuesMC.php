<?php
        $Question = $_POST['Question'];
        $Answer = $_POST['answer'];
	$Opt1 = $_POST['Opt1'];
	$Opt2 = $_POST['Opt2'];
	$Opt3 = $_POST['Opt3'];
	$Opt4 = $_POST['Opt4'];
        $diff = $_POST['diff'];
        $testMC = "cmd=addMCQuestion&Question=".$Question."&answer=".$Answer."&Opt1=".$Opt1."&Opt2=".$Opt2."&Opt3=".$Opt3."&Opt4=".$Opt4."&weight=".$diff;
        //echo $testMC;
$ch = curl_init();

curl_setopt( $ch,CURLOPT_URL,"http://afsaccess2.njit.edu/~ls339/cs490/middle/proc.php");
curl_setopt($ch,CURLOPT_POST,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$testMC);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$send=curl_exec($ch);
//echo $send;

$var = json_decode($send);
echo $var->{'message'};

if($var->{'message'}=='ok'){
    header('Location: create1.php');
}else{
    echo "Contact admin for more help";
}
?>