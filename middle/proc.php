<?php
  // ls339
  // proc.php : Description

  //echo $_POST["username"];
  //echo $_POST["password"];
  //$username=$_POST["username"];

function auth($username,$password) {

  $njit_data = array('user'=>$username,'pass'=>$password,'uuid'=>'0xACA021');
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://cp4.njit.edu/cp/home/login');
  curl_setopt($ch, CURLOPT_POST, 1);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, $njit_data);
  curl_setopt($ch, CURLOPT_POSTFIELDS, 'user='.$username.'&pass='.$password.'&uuid=0xACA021');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $njit_output = curl_exec($ch);
  //$auth_json = array ('login'=>'ok','username'=>$username,'type'=>'student');

  //echo $ch;
  //echo "njit_auth : username = ".$username." , password = ".$password."\n";
  //echo strpos($njit_output,"loginok.html");
  //echo json_encode($auth_json)."\n";
  $json = array();
  if(strpos($njit_output,"loginok.html")) {
    //echo json_encode($json = array('njit_login'=>'ok','username'=>$username));
    //$json = array('njit_login'=>'ok');
    $json["njit_login"]="ok";
  } else {
    //echo json_encode($json = array('login'=>'bad','username'=>$username));
    //echo "Bad login";
    $json["njit_login"] = "bad";
  }

  // curl function to backend
  $backend_ch = curl_init();
  //curl_setopt($backend_ch, CURLOPT_URL, 'http://osl82.njit.edu/~es66/login.php');
  curl_setopt($backend_ch, CURLOPT_URL, 'http://afsaccess2.njit.edu/~es66/login.php');
  curl_setopt($backend_ch, CURLOPT_POST, 1);
  //curl_setopt($backend_ch, CURLOPT_POSTFIELDS, 'cmd=auth&username='.$username.'&password='.$password);
  curl_setopt($backend_ch, CURLOPT_POSTFIELDS, 'user='.$username.'&password='.$password);
  curl_setopt($backend_ch, CURLOPT_RETURNTRANSFER, 1);
  $backend_output = curl_exec($backend_ch);
  $decoded_json = json_decode($backend_output);
  //echo $decoded_json->{"login"};
  if ($decoded_json->{"login"} == "success") {
    $json["backend_login"]="ok";
  } else {
    $json["backend_login"]="bad";
  }
  //$json["backend_login"] = "ok";
  //echo $backend_output."\n";
  echo json_encode($json);
}
//echo json_encode($json);

if ($_POST["cmd"]=="auth") {
  auth($_POST["username"],$_POST["password"]);
} 
?>