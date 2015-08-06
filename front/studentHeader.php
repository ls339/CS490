<?php
session_start();
include('header.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Online Quiz</title>
        <style> 
            li{
                display: inline;
            }
table,th,td    {
    border:1px solid black;
    border-collapse: collapse;}
th,td{padding: 10px;}
td,th      {background-color:lightgrey}
table,th,td    {
    border:1px solid black;
    border-collapse: collapse;}
question{
    font:italic bold;
    color:black;
}  
        </style>
    </head>
   <body>
            <img src="media/head.png" style="width:50px;height:50px;"> 
                <center>
            <div class="navbar navbar-default navbar-fixed-top" 
                 role="navigation">
                <div class="container">
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li class="active">
                                <a 
                                    href="student.php">Student</a>
                            </li>
                            <li>
                                <a 
                                    href="quizList.php">Take Quiz</a>
                            </li>
                            <li>
                                <a 
                                    href="getStudentGrade.php">Grade</a>
                            </li>
                            <li>
                                <a 
                                    href="Logout.php">LogOut</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div></center>
    <hr>