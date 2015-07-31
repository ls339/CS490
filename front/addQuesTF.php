<?php
        $Question = $_POST['Question'];
	$Answer = $_POST['Answer'];
        $diff = $_POST['diff'];
        $test = "cmd=addTFQuestion&Question=".$Question."&Answer=".$Answer."&weight=".$diff;
        //echo $test;
$ch = curl_init();

curl_setopt( $ch,CURLOPT_URL,"http://afsaccess2.njit.edu/~ls339/cs490/middle/proc.php");
curl_setopt($ch,CURLOPT_POST,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$test);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$send=curl_exec($ch);
//echo $send;

$var = json_decode($send);
//echo $var->{'message'};

if($var->{'message'}=='ok'){
    header('Location: create1.php');
}else{
    echo "Contact admin for more help";
}



        ?>

