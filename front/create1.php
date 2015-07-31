<?php
 ob_start();
    session_start();
    if(!isset($_SESSION['teacher']))header("Location: index.php");
    include('thead.php');
?>
<center><div class="content-create" id="TF">
<h1> True or False</h1>
<form action="addQuesTF.php" name="myform" method="POST">
    <b> Please type your question in the test box below</b>
    <br />
    <textarea id= "TF" name ="Question" style="width:400px;height:95px;"></textarea>
<br />
<br />
    <b>Please select whether true or false is the correct answer</b>
<br />
       <label style="cursor:pointer;">
                    <input type="radio" name="Answer" value="True">
                </label>
                    <input type="text" id="Opt1" name="Opt1" value="True" readonly>&nbsp;
            <br />
   	    <br />
                <label style="cursor:pointer;">
                    <input type="radio" name="Answer" value="False">
                </label>
                    <input type="text" id="Opt2" name="Opt2" value="False" readonly>&nbsp;
            <br />
            <input type="radio" name="diff" value="Easy">Easy
            <input type="radio" name="diff" value="medium">Medium
            <input type="radio" name="diff" value="hard">Hard
            <br/>
                <input type="hidden" value="TF" name="Type">
                <input type="submit" value="Add To Quiz">
</form>
<br/>
</div>
    
    
<div class="content-create" id="MC">
<h1> Multiple Choice</h1>
<form action="addQuesMC.php" name="question" method="POST">
    <b> Please insert new Question here</b>
    <br />
<textarea id="MCQ" name="Question" style="width:400px;height:95px;"></textarea>
<br />                    <br />
<b>Please create first answer here</b>
<br />
<label style="cursor:pointer;">
    <input type="radio" name="answer" value="A"></label>
<input type="text" id="Opt1" name="Opt1">
<br />
<b>Please create second answer here</b>
<br />
<label style="cursor:pointer;">
    <input type="radio" name="answer" value="B"></label>
<input type="text" id="Opt2" name="Opt2">
<br />
<b>Please create third answer here</b>
<br />
<label style="cursor:pointer;">
    <input type="radio" name="answer" value="C"></label>
<input type="text" id="Opt3" name="Opt3">
<br />
<b>Please create fourth answer here</b>
<br />
<label style="cursor:pointer;">
    <input type="radio" name="answer" value="D"></label>
<input type="text" id="Opt4" name="Opt4">
<br />
            <input type="radio" name="diff" value="Easy">Easy
            <input type="radio" name="diff" value="medium">Medium
            <input type="radio" name="diff" value="hard">Hard
            <br/>
<input type="hidden" value="MC" name="Type">
<input type="submit" value="Add To Quiz">
</form>
<br/>
</div>
<div class="content-create" id="OE">
    
    
<h1>Open Ended</h1>
<form action="addQuesOE.php" name="question" method="POST">
<b>Please type your Question here</b>
<br/>
<textarea id="OE" name="Question" style="width:400px;height:95px;"></textarea>
<br/>
 <b>Please type the Answer here</b>
 <br />		
 <textarea id="OEA" name="Answer" style="width:400px; min-height: 100px; max-height: none;"></textarea>
 <br /><input type="radio" name="diff" value="Easy">Easy
            <input type="radio" name="diff" value="medium">Medium
            <input type="radio" name="diff" value="hard">Hard
            <br/>
    <input type="hidden" value="OE" name="Type">
    <input type="submit" value="Add To Quiz">
    
</form></div></center>