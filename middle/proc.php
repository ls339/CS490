<?php

/*
 * Lewis Soto
 * proc.php
 * Final Version
*/

include "proc_func.php";

function auth($username, $password) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/login.php");
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
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/addquestions2.php");
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
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/addquestions2.php");
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
  curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/addquestions2.php");
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
    echo sortQuestions($questionList,$type,$weight);
}

function createExam($poststring) {

    $json = array();
    if($poststring["ExamName"] == "") {
        $json["status"] = "fail";
        $json["message"] = "You must provide an exam name!";
    } else if ($poststring["q0"] == "") {
        $json["status"] = "fail";
        $json["message"] = "There must be at least one question selected!";
    } else {
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/addtest.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "classId=0&usertype=1&testname=".$poststring["ExamName"]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
   
        /* Get test id */
        curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/gettest.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        $output = curl_exec($ch);
        
        $exams = json_decode($output);
        
        for($i = 0;$i < count($exams);$i++) {
            if($exams[$i]->{'TestName'}==$poststring["ExamName"]) $testId = $exams[$i]->{'Id'};
        }
        
         for ($i = 0; $i < count($poststring) - 3; $i++) {
            //echo "qid = ".$poststring['q'.$i]."<br>";
            curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/addtestquestions.php");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "usertype=1&testId=" . $testId . "&questionId=" . $poststring['q' . $i]);
            curl_exec($ch);
        }
            $json["status"] = "ok";
            $json["message"] = "Exam ".$poststring["ExamName"]." was added successfully.";
    }
    curl_close($ch);
    echo json_encode($json);
}

function getExams($userId) {
    
    $json = array();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/gettest.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ch_output = curl_exec($ch);
    $decoded_output = json_decode($ch_output);
    
    for($i = 0; $i < count($decoded_output); $i++) {
        curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/gettestsubmit.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "userid=".$userId."&testid=".$decoded_output[$i]->{'Id'});
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $out = curl_exec($ch);
        $tsubmit = json_decode($out);
        $testStatus = $tsubmit->{'Submitted'};
        $json[] = array('exam' => $decoded_output[$i]->{'TestName'},'testingStatus' => $testStatus );
    }
    echo json_encode($json);
}

function getExamList() {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/gettest.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    echo $output;
}

function takeExam($poststring) {
    $username = $poststring["username"];
    $exam = $poststring["examName"];
    $qid = $poststring["qid"];
    $userid = $poststring["userid"];
    $ch = curl_init();
    $TestId = getExamId($exam);

    if($TestId) {
        curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/gettestquestions.php");
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
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/getstudenttest.php");
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
    
    /* Getting options */
    if($type="oe") {
        curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/getqopts.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "qid=".$current);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $opts_output = curl_exec($ch);
        $opts = json_decode($opts_output);
        
        for($i = 0;$i < count($opts);$i++) {
            $json["Opt".$i] = $opts[$i]->{'Opt'};
        }
    }
    curl_close($ch);
    echo json_encode($json);
}

function submitExam($postdata) {
    
    $ch = curl_init();
    $json = array();
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/gettest.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $examList = json_decode($output);
    
    for($i = 0;$i < count($examList);$i++) {
        if ($examList[$i]->{'TestName'}==$postdata['examName']) $TestId = $examList[$i]->{'Id'};
    }
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/addstudenttestsubmit.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "studentid=".$postdata['userId']."&testid=".$TestId);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $json["message"] = "ok";
    curl_close($ch);
    echo json_encode($json);
}


function checkAnswer($postdata) {

    $json = array();
    $ch = curl_init();

    /* Get the test Id */
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/gettest.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $examList = json_decode($output);

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
    
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/addstudenttest.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "studentid=".$postdata["userId"]."&questionid=".$postdata["current"]."&studentanswer=".$postdata["Answer"]."&testid=".$TestId); // fix me
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $json["userAnswer"] = $postdata["Answer"];
    curl_close($ch);
    echo json_encode($json);
}

function examScores($username) {
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/getstudents.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $students = json_decode($output);
    
    for($i=0;$i<count($students);$i++) {
        curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/getstudenttestsubmit.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "studentid=".$students[$i]->{'UserId'});
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $testId = json_decode($output);

        for($j=0;$j<count($testId);$j++){ 
            $score = calculateScore($students[$i]->{'UserId'},$testId[$j]->{'TestId'});
            curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/gettest.php");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            $testlist = json_decode($output);
            for($k=0;$k<count($testlist);$k++){
                if($testlist[$k]->{'Id'} == $testId[$j]->{'TestId'}) $exam = $testlist[$k]->{'TestName'};
            }
            
            /* Find release status. */
            curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/getstudenttestsubmit.php");
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

function getScores($userId) {
    
    $json = array();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/getstudenttestsubmit.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "studentid=" . $userId);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $testsubmit = json_decode($output);

    for($i=0;$i<count($testsubmit);$i++){

        curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/gettest.php");
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
        curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/getstudenttest.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "studentid=" . $userId . "&testid=" . $examId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $questions = json_decode($output);
        
        $json['ExamName'] = $examName;
        $json['ExamId'] = $examId;
        $json['NumberOfQuestions'] = count($questions);

        for ($i = 0; $i < count($questions); $i++) {

            if($questions[$i]->{'studentanswer'} == $questions[$i]->{'correctanswer'} ) { 
                $json['qstatus'.$i] = "Correct";
            } else {
                $json['qstatus'.$i] = "Incorrect";
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
        }
        echo json_encode($json);
    }
    curl_close($ch);
}

function ReleaseScore($poststring) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/studentscorerelease.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "studentid=" . $poststring['studentId']."&testid=".$poststring['examId']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
}

function examInfo($examId) {
    $json = array();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/gettestquestions.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "TestId=" . $examId);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $questions = json_decode($output);
    $json[] = getExamName($examId);
    
    for($i=0;$i<count($questions);$i++) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/gettestquestionanswers.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "questionId=" . $questions[$i]->{'qid'});
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $answers = json_decode($output);
        if(getQuestionType($questions[$i]->{'qid'})=="Multiple Choice") {
            $opts = json_decode(getMCOptions($questions[$i]->{'qid'}));
            $json[] = array('qid'=>$questions[$i]->{'qid'},'question'=>$questions[$i]->{'question'},'answer'=>getMCQuestionAnswer($answers[0]->{'answersCorrect'},$questions[$i]->{'qid'}),'type'=>getQuestionType($questions[$i]->{'qid'}),'weight'=>getQuestionWeight($questions[$i]->{'qid'}),'opt1'=> $opts[0]->{'Opt'},'opt2'=> $opts[1]->{'Opt'},'opt3'=> $opts[2]->{'Opt'},'opt4'=> $opts[3]->{'Opt'});
        } else {
            $json[] = array('qid'=>$questions[$i]->{'qid'},'question'=>$questions[$i]->{'question'},'answer'=>$answers[0]->{'answersCorrect'},'type'=>getQuestionType($questions[$i]->{'qid'}),'weight'=>getQuestionWeight($questions[$i]->{'qid'}));
        } 
        
    }
    
    curl_close($ch);
    echo json_encode($json);
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
    case "examInfo":
        examInfo($_POST['examId']);
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
