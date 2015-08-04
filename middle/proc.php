<?php
  // ls339
  // FINAL

include "proc_func.php";

function auth($username, $password) {
    $ch = curl_init();
    // Need to point to real backend
    //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/login.php");
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/login.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'user='.$username.'&password='.$password);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $decoded_json = json_decode($output);
    if ($decoded_json->{"login"} == "success") {
        $json["login"] = "ok";
        if ($decoded_json->{"Type"} == "1") {
            $json["type"] = "instructor";
        } else {
            $json["type"] = "student";
        }
        $json["username"] = $decoded_json->{"username"};
        $json["userId"] = $decoded_json->{"UserId"};
        $json["firstname"] = $decoded_json->{"First"};
        $json["lastname"] = $decoded_json->{"Last"};
        $json["email"] = $decoded_json->{"Email"};
    } else {
        $json["login"] = "bad";
    }
    curl_close($ch);
    echo json_encode($json);
}

function addTFQuestion($question, $answer, $difficulty) {   
    if($difficulty=="Easy") $weight = 1;
    if($difficulty == "medium") $weight = 2;
    if($difficulty == "hard") $weight = 3;
    $json = array();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/addquestions2.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "usertype=1&questionName=" . $question . "&questionanswer=" . $answer . "&questionType=2&weight=".$weight);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $decoded_json = json_decode($output);
    curl_close($ch);
    $json["message"] = "ok";
    $json["qid"] = "True False";
    echo json_encode($json);
}

function addMCQuestion($poststring) {
    if($poststring["weight"] == "Easy") $weight = 1;
    if($poststring["weight"] == "medium") $weight = 2;
    if($poststring["weight"] == "hard") $weight = 3;
    $question = $poststring["Question"];
    $answer = $poststring["answer"];
    $options = array($poststring["Opt1"],$poststring["Opt2"],$poststring["Opt3"],$poststring["Opt4"]);
    $json = array();
    $datatest = "questionName=" . $question . "&questionanswer=" . $answer . "&questionType=1&Opt1=".$options[0]."&Opt2=".$options[1]."&Opt3=".$options[2]."&Opt4=".$options[3]."&weight=".$weight;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/addquestions2.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "usertype=1&questionName=" . $question . "&questionanswer=" . $answer . "&questionType=1&Opt1=".$options[0]."&Opt2=".$options[1]."&Opt3=".$options[2]."&Opt4=".$options[3]."&weight=".$weight);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    $json["message"] = "ok";
    $json["qid"] = "Multiple Choice";
    echo json_encode($json);
}

function addOEQuestion($question,$answer,$difficulty) {
  if($difficulty=="Easy") $weight = 1;
  if($difficulty == "medium") $weight = 2;
  if($difficulty == "hard") $weight = 3;
  $json = array();
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/addquestions2.php");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, "usertype=1&questionName=" . $question . "&questionanswer=" . $answer . "&questionType=3&weight=".$weight);  // FIX ME
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $output = curl_exec($ch);
  curl_close($ch);
  $decoded_json = json_decode($output);
  $json["message"] = "ok";
  $json["qid"] = "Fill in the blank";
  echo json_encode($json);
}

function newExam($poststring) {

    $weight = $poststring['weight'];
    $type = $poststring['type'];
    $questionList = getQuestionList();
    //echo $weight;
    
    //echo $poststring['weight'] . "\n";
    //echo $poststring['type'] . "\n";
    /*
    if ($poststring['weight'] == "") {
        echo "weight empty";
    }
     * 
     */
    //if(!isSet($poststring['weight']) && !isSet($type)) {
    echo sortQuestions($questionList,$type,$weight);
    /*if ($type == "All" && $weight == "All") {
        echo $questionList;
        //echo getQuestionList();
        //echo json_encode(array(array('qid' => '2', 'question' => 'in the if', 'weight' => '1', 'type' => 'True False')));
    } else {
        echo sortQuestions($questionList,$type,$weight);
    }
     * 
     */

        /*
    } else if($type == "True False" && $weight == "All") {
        echo sortQuestions($questionList,$type,$weight);
    } else if($type == "True False" && $weight == "Easy") {
        echo sortQuestions($questionList,$type,$weight);
        //echo json_encode(array(array('qid' => '1', 'question' => 'True False Easy', 'weight' => '1', 'type' => 'True False')));
    } else if($type == "True False" && $weight == "Medium") {
        echo json_encode(array(array('qid' => '1', 'question' => 'True False Medium', 'weight' => '1', 'type' => 'True False')));
    } else if($type == "True False" && $weight == "Hard") {
        echo json_encode(array(array('qid' => '1', 'question' => 'True False Hard', 'weight' => '1', 'type' => 'True False')));
    } else if($type == "Multiple Choice" && $weight == "All") {
        echo json_encode(array(array('qid' => '1', 'question' => 'MC ALL', 'weight' => '1', 'type' => 'adfads')));
    } else if($type == "Multiple Choice" && $weight == "Easy") {
        echo json_encode(array(array('qid' => '1', 'question' => 'MC easy', 'weight' => '1', 'type' => 'True False')));
    } else if($type == "Multiple Choice" && $weight == "Medium") {
        echo json_encode(array(array('qid' => '1', 'question' => 'MC medium', 'weight' => '1', 'type' => 'True False')));
    } else if($type == "Multiple Choice" && $weight == "Hard") {
        echo json_encode(array(array('qid' => '1', 'question' => 'MC hard', 'weight' => '1', 'type' => 'True False')));
    } else if($type == "Fill in the blank" && $weight == "All") {
        echo json_encode(array(array('qid' => '1', 'question' => 'FITB ALL', 'weight' => '1', 'type' => 'True False')));
    } else if($type == "Fill in the blank" && $weight == "Easy") {
        echo json_encode(array(array('qid' => '1', 'question' => 'FITB Easy', 'weight' => '1', 'type' => 'True False')));
    } else if($type == "Fill in the blank" && $weight == "Medium") {
        echo json_encode(array(array('qid' => '1', 'question' => 'FITB Medium', 'weight' => '1', 'type' => 'True False')));
    } else if($type == "Fill in the blank" && $weight == "Hard") {
        echo json_encode(array(array('qid' => '1', 'question' => 'FITB Hard', 'weight' => '1', 'type' => 'True False')));
    }
*/
    //echo getQuestionList();
    //echo json_encode(array(array('qid'=>'1','question'=>'the question','weight'=> '1','type'=> 'True False')));
}

function createExam($poststring) {
    
    /*
     * Adding a Test/Exam 
     * Sending :
     * $classId=$_POST["classId"];
     * $usertype=$_POST["usertype"];
     * $testname=$_POST["testname"];
     * curl --data "classId=1&usertype=1&testname=mytest" http://afsaccess2.njit.edu/~es66/addtest.php
     * Check if adding exam exists
     * Returns json message
     */
    
    $json = array();
    if($poststring["ExamName"] == "") {
        $json["status"] = "fail";
        $json["message"] = "You must provide an exam name!";
    // Need to fix logic on how to tell if no questions were selected.
    } else if ($poststring["q0"] == "") {
        $json["status"] = "fail";
        $json["message"] = "There must be at least one question selected!";
    } else {
        
        $ch = curl_init();
        //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/beta/model.php");  // Mock Backend
        //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/addtestquestions.php");  // Real Backend
        curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/addtest.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $poststring);  // Mock Backend
        curl_setopt($ch, CURLOPT_POSTFIELDS, "classId=0&usertype=1&testname=".$poststring["ExamName"]);  // FIX ME
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        
        curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/gettest.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        $output = curl_exec($ch);
        
        $exams = json_decode($output);
        
        for($i = 0;$i < count($exams);$i++) {
            if($exams[$i]->{'TestName'}==$poststring["ExamName"]) $testId = $exams[$i]->{'Id'};
        }
        //echo $testId;
        
        for($i = 0;$i < count($_POST)-3;$i++) {
            //echo "qid = ".$_POST['q'.$i]."<br>";
            curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/addtestquestions.php");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "usertype=1&testId=".$testId."&questionId=".$_POST['q'.$i]);
            curl_exec($ch);
        } 
         
        //echo count($poststring["qid"]);
        //echo $poststring["qid"]["1"];
/// THIS LOGIC DOES NOT WORK, NEED TO RETHINL THIS
        //for($i=0;$i<count($poststring)-2;$i++) {
        //    echo $poststring["q".$i];
        //}
 
        // Need different check for real backend
        //if(json_decode($output)->{"status"} == "ok") {
            $json["status"] = "ok";
            $json["message"] = "Exam ".$poststring["ExamName"]." was added successfully.";
        //}
    }
    ///curl_close($ch);
    
    // Pretending to have processed something.
    //$json["message"] = "exam successfully added";
    echo json_encode($json);
}

function getExams($userId) {
     //
    //get a list of tests
    // curl --data "classId=1" http://afsaccess2.njit.edu/~es66/gettest.php
    //return array of tests
    // [{"Id":"0","TestName":"Cs100"},{"Id":"99","TestName":"CSSSS"}]
    
    $json = array();
    $ch = curl_init();
    //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/beta/model.php"); // Mock Backend
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/gettest.php"); // Real Backend
    curl_setopt($ch, CURLOPT_POST, 1);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=getExams");  // Mock Backend
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "classId=1"); // Real Backend
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ch_output = curl_exec($ch);
    $decoded_output = json_decode($ch_output);
    
    //echo $userId;
    //echo count($decoded_output);
    for($i = 0; $i < count($decoded_output); $i++) {
        //$json[] = array("exam" => substr($decoded_output[$i]->{"exam"},11));
        // Need to the user id to check the availabilty of the exam to the user.
        //$testStatus = 0;
        // Need to copy this to real backend
        //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/gettestsubmit.php");
        curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/gettestsubmit.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "userid=".$userId."&testid=".$decoded_output[$i]->{'Id'});
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $out = curl_exec($ch);
        //echo $out;
        //echo "userid=".$userId."&testid=".$decoded_output[$i]->{'Id'};
        $tsubmit = json_decode($out);
        //echo count($tsubmit);
        //echo "decode out".$decoded_output[$i]->{'Id'}."<br>";
        //echo "SUBMITTED VALUE = ".$tsubmit[$i]->{'Submitted'}."<br>";
        $testStatus = $tsubmit->{'Submitted'};
        //echo $testStatus;
        $json[] = array('exam' => $decoded_output[$i]->{'TestName'},'testingStatus' => $testStatus );
        //echo $i;
    }
    echo json_encode($json);
}

function getExamList() {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/gettest.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    echo $output;
}

//function takeExam($exam, $username, $qid) {
function takeExam($poststring) {
    $username = $poststring["username"];
    $exam = $poststring["examName"];
    $qid = $poststring["qid"];
    $userid = $poststring["userid"];
    $ch = curl_init();
    $TestId = getExamId($exam);

    if($TestId) {
        curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/gettestquestions.php");
        //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/middle/beta/gettestquestions.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "TestId=".$TestId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $questions = json_decode($output);
        $qnum = count($questions);
    } else {
        echo "No questions found.";
    }        
    $json = array();
    
    $count = count($questions);
    if ($qid == "") {
        $question = $questions[0]->{"question"};
        $current = $questions[0]->{"qid"};
        //$type = $questions[0]->{"type"};
        $next = $questions[1]->{"qid"};
    } else {
        for ($i = 0; $i < $count; $i++) {
            if($qid == $questions[$i]->{"qid"}) {
                $question = $questions[$i]->{"question"};
                $current = $questions[$i]->{"qid"};
                $previous = $questions[$i-1]->{"qid"};
                $next = $questions[$i+1]->{"qid"};
            }
        }
    }
    
    /* Check if answer exists */
    //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/getstudenttest.php");
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/getstudenttest.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "studentid=" . $userid . "&testid=" . $TestId); // fix me
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $answer_output = curl_exec($ch);
    $answers = json_decode($answer_output);
    $anum = count($answers);
    
    for($i=0;$i<count($answers);$i++) {
        if($answers[$i]->{'QuestionId'} == $current) $userAnswer = $answers[$i]->{'studentanswer'};
    }
    
    /* Getting type */

    $type = getQuestionType($current);
    if($type=="Multiple Choice") $type = "mc";
    if($type=="True False") $type = "tf";
    if($type=="Fill in the blank") $type = "oe";
    
    $json['numberOfQuestions'] = $qnum;
    $json['numberOfAnsweredQuestions'] = $anum;
    $json["type"] = $type;
    $json["question"] = $question;
    $json["current"] = $current;
    $json["previous"] = $previous;
    $json["next"] = $next;
    $json["userAnswer"] = $userAnswer;   
    
    // Getting options
    if($type="oe") {
        //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/middle/beta/getqopts.php");
        curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/getqopts.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "qid=".$current);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $opts_output = curl_exec($ch);
        $opts = json_decode($opts_output);
        
        for($i = 0;$i < count($opts);$i++) {
            $json["Opt".$i] = $opts[$i]->{'Opt'};
        }
    }
     
    echo json_encode($json);
}

// May not need this function
/*
function updateQuestion($qid,$status,$exam) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/beta/model.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=updateQuestion&exam=" . $exam . "&qid=" . $qid."&status=".$status);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ch_output = curl_exec($ch);
    echo $ch_output;
}
 * 
 */

function submitExam($postdata) {
    
    $ch = curl_init();
    $json = array();
    
    //echo $qid;
    /*
     * Get my the exam Id
     */
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/gettest.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    //echo $output;
    $examList = json_decode($output);
    //echo $output;
    //echo $examList[2]->{'Id'};
    for($i = 0;$i < count($examList);$i++) {
        if ($examList[$i]->{'TestName'}==$postdata['examName']) $TestId = $examList[$i]->{'Id'};
    }
    
    //echo $postdata['userId'];
    //echo $postdata['examName'];
    //echo $TestId;
    
    
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/addstudenttestsubmit.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "studentid=".$postdata['userId']."&testid=".$TestId);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    
    //echo "studentid=".$postdata['userId']."&testid=".$TestId;
    //echo "|".$postdata['userId']."|";
    //$json["examName"] = $postdata["examName"];
    //$json["user"] = $postdata["user"];
    $json["message"] = "ok";
    echo json_encode($json);
}

// Do I really need this? Yes I do.
function checkAnswer($postdata) {
    //echo "in check answer";
///function checkAnswer($qid, $answer, $exam) {
    $json = array();
    $ch = curl_init();

    /* Get the test Id */
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/gettest.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $examList = json_decode($output);
    //echo "CCCCCC";    
    //echo $examList[2]->{'Id'};
    for ($i = 0; $i < count($examList); $i++) {
        if ($examList[$i]->{'TestName'} == $postdata["examName"])
            $TestId = $examList[$i]->{'Id'};
    }
    
    $json["user"] = $postdata["user"];
    $json["userId"] = $postdata["userId"];
    $json["qid"] = $postdata["current"];
    $json["answer"] = $postdata["Answer"];
    $json["examName"] = $postdata["examName"];
    $json['examId'] = $TestId;
    //echo $TestId;
    $ch = curl_init();
    
    $datatest = "studentid=".$postdata["userId"]."&questionid=".$postdata["current"]."&studentanswer=".$postdata["Answer"]."&testid=".$TestId;
    //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/addstudenttest.php");
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/addstudenttest.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=getQuestions");
    curl_setopt($ch, CURLOPT_POSTFIELDS, "studentid=".$postdata["userId"]."&questionid=".$postdata["current"]."&studentanswer=".$postdata["Answer"]."&testid=".$TestId); // fix me
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    ///$decoded_json = json_decode($output);
    //echo $datatest;
    //echo $output;
    //echo count($decoded_json);
    /*
    for ($i = 0; $i < count($decoded_json); $i++) {
        if($decoded_json[$i]->{"qid"} == $qid ) {
            $db_answer = $decoded_json[$i]->{"answer"};
        }
    }
    if ($db_answer == $answer) {
        $result = "ok";
        updateQuestion($qid,1,$exam);
    } else {
        $result = "bad";
        updateQuestion($qid,0,$exam);
    }
     * 
     */
    //echo "input qid ".$qid."<br>";
    //echo "input answer ".$answer."<br>";
    //echo "db answer ".$db_answer."<br>";
    ///$json["qid"] = $qid;
    $json["userAnswer"] = $postdata["Answer"];
    ///$json["realAnswer"] = $db_answer;
    ///$json["result"] = $result;
  
    
    echo json_encode($json);
}

function examScores($username) {
    
    $ch = curl_init();
    //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/middle/beta/getstudents.php");
    //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/getstudents.php");
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/getstudents.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    //echo $output;
    $students = json_decode($output);
    
    for($i=0;$i<count($students);$i++) {
        curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/getstudenttestsubmit.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "studentid=".$students[$i]->{'UserId'});
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $testId = json_decode($output);

        for($j=0;$j<count($testId);$j++){ 
            $score = calculateScore($students[$i]->{'UserId'},$testId[$j]->{'TestId'});
            curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/gettest.php");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            $testlist = json_decode($output);
            for($k=0;$k<count($testlist);$k++){
                if($testlist[$k]->{'Id'} == $testId[$j]->{'TestId'}) $exam = $testlist[$k]->{'TestName'};
            }
            
            /* Find release status. */
            curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/getstudenttestsubmit.php");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "studentid=" . $students[$i]->{'UserId'});
            $output = curl_exec($ch);
            $teststatus = json_decode($output);
            
            for($k=0;$k<count($teststatus);$k++) {
                if($teststatus[$k]->{'TestId'}==$testId[$j]->{'TestId'}) $releaseStatus = $teststatus[$k]->{'ScoreRelease'};
            }
            
            $json[] = array('name'=>$students[$i]->{'FirstName'}." ".$students[$i]->{'LastName'},"releaseStatus" => $releaseStatus,'exam' => $exam, 'score' => $score, 'studentId' => $students[$i]->{'UserId'},'examId' => $testId[$j]->{'TestId'});
        }
    }
    curl_close($ch);
    echo json_encode($json);
}
// Do I really need this? Yes I do
function getScores($userId) {
    
    $json = array();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/getstudenttestsubmit.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "studentid=" . $userId);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $testsubmit = json_decode($output);

    for($i=0;$i<count($testsubmit);$i++){

        curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/gettest.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $testlist = json_decode($output);
        
        for ($j = 0; $j < count($testlist); $j++) {
            if ($testlist[$j]->{'Id'} == $testsubmit[$i]->{'TestId'}) {
                $exam = $testlist[$j]->{'TestName'};
            }
        }

        if($testsubmit[$i]->{'ScoreRelease'}==1) {
            $score = calculateScore($userId, $testsubmit[$i]->{'TestId'});
            $json[] = array('exam' => $exam, 'score' => $score);
        }

    }
    curl_close($ch);
    echo json_encode($json);
}

function getFeedback($userId, $examName) {

    $json = array();
    $examId = getExamId($examName);
    if (isSubmitted($userId, $examId)) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/getstudenttest.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "studentid=" . $userId . "&testid=" . $examId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $questions = json_decode($output);
        
        $json['ExamName'] = $examName;
        $json['ExamId'] = $examId;
        $json['NumberOfQuestions'] = count($questions);
        //echo $output;
        for ($i = 0; $i < count($questions); $i++) {
            //echo $questions[$i]->{'studentanswer'};
            if($questions[$i]->{'studentanswer'} == $questions[$i]->{'correctanswer'} ) { 
                //$json['q'.$i] = "Wrong";
                $json['qstatus'.$i] = "Correct";
                //$json[] = array('status' => "Wrong")
                //$questionStatus = "Correct";
            } else {
                $json['qstatus'.$i] = "Incorrect";
                //$questionStatus = "Incorrect";
            }
            $json['question'.$i] = getQuestion($questions[$i]->{'QuestionId'});
            $json['qtype'.$i] = getQuestionType($questions[$i]->{'QuestionId'});
            $json['qweight'.$i] = $questions[$i]->{'weight'};
            
            if(getQuestionType($questions[$i]->{'QuestionId'})=="Multiple Choice") {
                $json['answer'.$i] = getMCQuestionAnswer($questions[$i]->{'correctanswer'},$questions[$i]->{'QuestionId'});
                $json['youranswer'.$i] = getMCQuestionAnswer($questions[$i]->{'studentanswer'},$questions[$i]->{'QuestionId'});
            } else {
                $json['answer'.$i] = $questions[$i]->{'correctanswer'};
                $json['youranswer'.$i] = $questions[$i]->{'studentanswer'};
            }
            //$json['answer'.$i] = $questions[$i]->{'correctanswer'};
            //$json['youranswer'.$i] = $questions[$i]->{'studentanswer'};
            //$json[] = array('status' => $questionStatus,'question' => $questions[$i]->{'QuestionId'});
        }
        echo json_encode($json);
    }
    //echo getExamId($examName);
}

function ReleaseScore($poststring) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/studentscorerelease.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "studentid=" . $poststring['studentId']."&testid=".$poststring['examId']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
}

function editExam($examId) {
    $json = array();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/gettestquestions.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "TestId=" . $examId);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $questions = json_decode($output);
    //echo $output;
    $json[] = getExamName($examId);
    
    for($i=0;$i<count($questions);$i++) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/gettestquestionanswers.php");
        //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/gettestquestionanswers.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "questionId=" . $questions[$i]->{'qid'});
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $answers = json_decode($output);
        //echo $output;
        //echo count($answers);
        if(getQuestionType($questions[$i]->{'qid'})=="Multiple Choice") {
            $opts = json_decode(getMCOptions($questions[$i]->{'qid'}));
            $json[] = array('qid'=>$questions[$i]->{'qid'},'question'=>$questions[$i]->{'question'},'answer'=>getMCQuestionAnswer($answers[0]->{'answersCorrect'},$questions[$i]->{'qid'}),'type'=>getQuestionType($questions[$i]->{'qid'}),'weight'=>getQuestionWeight($questions[$i]->{'qid'}),'opt1'=> $opts[0]->{'Opt'},'opt2'=> $opts[1]->{'Opt'},'opt3'=> $opts[2]->{'Opt'},'opt4'=> $opts[3]->{'Opt'});
        } else {
            $json[] = array('qid'=>$questions[$i]->{'qid'},'question'=>$questions[$i]->{'question'},'answer'=>$answers[0]->{'answersCorrect'},'type'=>getQuestionType($questions[$i]->{'qid'}),'weight'=>getQuestionWeight($questions[$i]->{'qid'}));
        } 
        
    }
    
    curl_close($ch);
    echo json_encode($json);
    //echo getQuestionList();
}

// For features
/*
function getStudents() {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/middle/beta/getstudents.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    echo $output;
}
 * 
 */

function passwordReset($username,$email) {
    echo "in passwordReset";
}

/* Main */
switch ($_POST["cmd"]) {
    case "auth":
        auth($_POST["username"], $_POST["password"]);
        break;
    case "addTFQuestion":
        addTFQuestion($_POST["Question"], $_POST["Answer"], $_POST["weight"]);
        break;
    case "addMCQuestion":
        addMCQuestion($_POST);
        break;
    case "addOEQuestion":
        addOEQuestion($_POST["Question"],$_POST["Answer"],$_POST["weight"]);
        break;
    case "newExam":
        newExam($_POST);
        break;
    case "createExam":
        createExam($_POST);
        break;
    case "getExams":
        getExams($_POST['userId']);
        break;
    case "getExamList":
        getExamList();
        break;
    case "takeExam":
        takeExam($_POST);
        break;
    case "checkAnswer":
        checkAnswer($_POST);
        break;
    case "submitExam":
        submitExam($_POST);
        break;
    case "examScores":
        examScores($_POST["username"]);
        break;
    case "editExam":
        editExam($_POST['examId']);
        break;
    case "getFeedback":
        getFeedback($_POST["userId"],$_POST["exam"]);
        break;
    case "getScores":
        getScores($_POST["userId"]);
        break;
    case "releaseScore":
        releaseScore($_POST);
        break;
    case "getStudents":
        getStudents();
        break;
    case "getQuestion":
        echo getQuestion($_POST['qid']);
        break;
    default:
        echo "You need to send me a command, for example: cmd = auth ";
}
 
?>