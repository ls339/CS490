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
        </style>
    </head>
    <center><body>
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
            </div></body></center>

                <!--subQuiz-->
                <?php
                /* $Name = $_POST['quizname'];
                  $MC = $_POST['multiplechoice'];
                  $TF = $_POST['truefalse'];
                  $OE = $_POST['openended'];

                  $fields = json_encode(array('QuizName' => $Name, 'MultipleChoice' => $MC, 'TrueFalse' => $TF, 'OpenEnded' => $OE, 'FeedBack'=>'FeedBack'));
                  //echo $fields;

                  $crl = curl_init();
                  //curl_setopt($crl, CURLOPT_URL, "http://web.njit.edu/~ovl2/CS490/Back/grade.php");
                  curl_setopt($crl, CURLOPT_URL, "http://web.njit.edu/~rab25/CS490/Test/populate.php.php");
                  curl_setopt($crl, CURLOPT_POST, 1);
                  curl_setopt($crl, CURLOPT_POSTFIELDS, $Qus);
                  curl_setopt($crl, CURLOPT_FOLLOWLOCATION, 1);

                  $outputDB = curl_exec($crl);
                  curl_close($crl); */
                ?>
