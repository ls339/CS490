<?php
     ob_start();
    session_start();
    if(!isset($_SESSION['student']))header("Location: index.php");
    include('studentHeader.php');
?>
<?php

$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL,"https://web.njit.edu/~ls339/cs490/middle/proc.php");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$send = curl_exec($ch);
echo $send;

$var=  json_decode($send);

if($var->{'message'}=='ok'){
    header('Location: quizList.php');
}else{
    echo "Contact admin for more help";
}
?>

