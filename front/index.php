<?php
    session_start();
    
    include('header.php');
?>

<!DOCTYPE html>
<html>
<head>
<title>CS490</title>
</head>
<body>

<script src="java.js"></script>
<center><h1>WELCOME</h1>
<p>This is the last website you will EVER log into</p>
<img src="media/mozilla_firefox.png" style="width:30px;height:30px;">
<form action='cetch.php' method="POST">

<br>
Username:<br>
<input type="text" name="username">
<br>
Password:<br>
<input type="password" name="password">
<br><br>

<input name="submit" type="submit" value="Login"><!--<li>
                                <a href="forgotpass.php">Forgot Password</a>
                            </li>-->
</form>
</center>
</body>
</html>


