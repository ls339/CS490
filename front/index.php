<?php
    session_start();
    
    include('header.php');
?>

<!DOCTYPE html>
<html>
<head>
<title>CS490</title>
<body>

<script src="java.js"></script>
<center><h1>WELCOME</h1>
<p>This is the last website you will EVER log into</p>

<form action='cetch.php' method="POST">

<br>
Username:<br>
<input type="text" name="username">
<br>
Password:<br>
<input type="password" name="password">
<br><br>

<input name="submit" type="submit" value="Submit"><!--<li>
                                <a href="forgotpass.php">Forgot Password</a>
                            </li>-->
</form>
<p id ="output"></p>
</center>
</body>
</html>


