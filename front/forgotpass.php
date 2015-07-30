<?php
ob_start();
session_start();
if(!isset($_SESSION['user']));
include('header.php');
?>
<!DOCTYPE html>
<html>
<head>
<style>
    body    {background-color:#33ffff}
</style>
<title>Forgot Password</title>
<body>
    <?php
if (!$username) {
    if ($_POST['resetbtn']) {
        $user = $_POST['user'];
        $email = $_POST['email'];
        if ($user) {
            if ($email) {
                
            }echo "Please enter your Email";
        }echo "Please enter your Username";
    }
    echo"<form action='./forgotpass.php'>
            <table>
            <tr>
            <td> Usename: </td>
            <td><input type='text' name='user' /></td>
            </tr>
            <tr>
            <td> Email: </td>
            <td><input type='text' name='email' /></td>
            </tr>
            <tr>
            <td></td>
            <td><input type='submit' name='resetbtn' value='Reset Password'/></td>
            </tr>
        </form>";
} else {
    echo "Please logout to view this page.";
}
?>
</body></head>

