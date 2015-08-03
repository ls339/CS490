<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
session_start();
include('header.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<title>Grades</title>
        <style> 
            li{
            display: inline;
            }
p       {color:green}
a       {color:black;
             background-color:white;
             size: '10';
}
td,th      {background-color:lightgrey}
table,th,td    {
    border:1px solid black;
    border-collapse: collapse;}
th,td{padding: 15px;}

</style>
        </head>
    <body>
	<div id="wrap">
	    <div class="navbar navbar-default navbar-fixed-top" 
role="navigation">
                <center><div class="container">
			    <li class="active">
				<a 
href="teacher.php">Teacher</a>
			    </li>
                            <li>
                                <a 
href="create1.php">Create Quiz Questions</a>
                            </li>
                            <li>
                                <a 
href="createQuiz.php">Make Quiz</a>
                            </li>
			    <li>
				<a 
href="studentGrade.php">Grades</a>
			    </li>
			    <li>
				<a 
href="Logout.php">LogOut</a>
			    </li>
			</ul>
                    </div></center>
		</div>
	    </div>