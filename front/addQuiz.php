<?php

$post = array();
$qid = array();
for ($i = 0; $i < count($_POST['qid']); $i++) {
    $post['q' . $i] = $_POST['qid'][$i];
}
$post['ExamName'] = $_POST['ExamName'];
$post['cmd'] = $_POST['cmd'];
$post['qid'] = $qid;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~ls339/cs490/middle/proc.php");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$send = curl_exec($ch);
echo $send;
$var = json_decode($send);
echo "status = ".$var->{'status'};
if ($var->{'status'} == 'ok') {
    header('Location: createQuiz2.php');
} else {
    include('header.php');
    echo "Contact admin for more help";
    echo "<br>";
    echo $var->{'message'};
}
?>

