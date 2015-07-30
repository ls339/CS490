<?php
  // ls339
  // proc.php : BETA to RC

function auth($username, $password) {

    // curl function to backend
    $ch = curl_init();
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
        //$json["type"]=$decoded_json->{"type"};
        $json["username"] = $decoded_json->{"username"};
        $json["userId"] = $decoded_json->{"UserId"};
        $json["firstname"] = $decoded_json->{"firstname"};
        $json["lastname"] = $decoded_json->{"lastname"};
    } else {
        $json["login"] = "bad";
    }
    curl_close($ch);
    echo json_encode($json);
}

function addTFQuestion($question, $answer, $difficulty) {   
    $json = array();
    $ch = curl_init();
    //echo $difficulty;
    if($difficulty=="Easy") $weight = 1;
    if($difficulty == "medium") $weight = 2;
    if($difficulty == "hard") $weight = 3;
    
    //echo $weight;
    //$weight = 3; 
    //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/beta/model.php"); // Mock Backend
    //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/addquestions.php"); // Real Backend
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/addquestions2.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=addTFQuestion&question=".$question."&answer=".$answer); // Mock Backend
    curl_setopt($ch, CURLOPT_POSTFIELDS, "usertype=1&questionName=" . $question . "&questionanswer=" . $answer . "&questionType=2&weight=".$weight);  // Real Backend
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $decoded_json = json_decode($output);
   
    /*
    if ($decoded_json->{"addQuestion"} == "success") {
        $json["message"] = "Successfully added True | False question # " . $decoded_json->{"qid"};
    } else if ($decoded_json->{"addQuestion"} == "fail") {
        $json["message"] = "Error";
    } else {
        $json["message"] = "Unknown Error";
    }
     * 
     */
    curl_close($ch);


    // Pretending to have processed something.
    //$json["weight"] = $weight;
    //$json["message"] = "Successfully added True | False question";
    $json["message"] = "ok";
    echo json_encode($json);

}
function addMCQuestion($poststring) {
    $question = $poststring["Question"];
    $answer = $poststring["answer"];
    $options = array($poststring["Opt1"],$poststring["Opt2"],$poststring["Opt3"],$poststring["Opt4"]);
    //$weight = $poststring["weight"];
    if($poststring["weight"] == "Easy") $weight = 1;
    if($poststring["weight"] == "medium") $weight = 2;
    if($poststring["weight"] == "hard") $weight = 3;
    //$weight = "9";
    //echo $options[1];
    $json = array();
    //$datastring = "questionName=" . $question . "&answer=" . $answer . "&questionType=1&Opt1=".$options[0]."&Opt2=".$options[1]."&Opt3=".$options[2]."&Opt4=".$options[3]."&weight=".$weight; 
    //echo $datastring;
    //echo "questionName=" . $question . "&answer=" . $answer . "&questionType=1&Opt1=".$options[0]."&Opt2=".$options[1]."&Opt3=".$options[2]."&Opt4=".$options[3]"
    $datatest = "questionName=" . $question . "&questionanswer=" . $answer . "&questionType=1&Opt1=".$options[0]."&Opt2=".$options[1]."&Opt3=".$options[2]."&Opt4=".$options[3]."&weight=".$weight;
    
    $ch = curl_init();
    //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/beta/model.php");
    //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/addquestions.php");
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/addquestions2.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=addTFQuestion&question=".$question."&answer=".$answer);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "questionName=" . $question . "&answer=" . $answer . "&questionType=1&Opt1=".$options[0]."&Opt2=".$options[1]."&Opt3=".$options[2]."&Opt4=".$options[3]."&weight=".$weight);  // FIX ME
    curl_setopt($ch, CURLOPT_POSTFIELDS, "usertype=1&questionName=" . $question . "&questionanswer=" . $answer . "&questionType=1&Opt1=".$options[0]."&Opt2=".$options[1]."&Opt3=".$options[2]."&Opt4=".$options[3]."&weight=".$weight);  // FIX ME
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    //$decoded_json = json_decode($output);
    
    //echo $output;
    //echo $datatest;
    /*
    $json["question"] = $question;
    $json["answer"] = $answer;
    $json["options"] = $options;
    $json["weight"] = $weight;
    */
/*
    if ($decoded_json->{"addQuestion"} == "success") {
        $json["message"] = "Successfully added True | False question # " . $decoded_json->{"qid"};
    } else if ($decoded_json->{"addQuestion"} == "fail") {
        $json["message"] = "Error";
    } else {
        $json["message"] = "Unknown Error";
    }
    curl_close($ch);
 
 */
    // Pretending to have processed something.
    //$json["message"] = "Successfully added MC question";
    $json["message"] = "ok";
    echo json_encode($json);
}
function addOEQuestion($question,$answer,$difficulty) {

  //echo $question."<br>";
  //echo $answer."<br>";
  if($difficulty=="Easy") $weight = 1;
  if($difficulty == "medium") $weight = 2;
  if($difficulty == "hard") $weight = 3;
  $json = array();
  $ch = curl_init();
  //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/beta/model.php");
  //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/addquestions.php");
  curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/addquestions2.php");
  curl_setopt($ch, CURLOPT_POST, 1);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=addOEQuestion&question=".$question."&answer=".$answer);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, "questionName=" . $question . "&answer=" . $answer . "&questionType=3&weight=".$weight);  // FIX ME
  curl_setopt($ch, CURLOPT_POSTFIELDS, "usertype=1&questionName=" . $question . "&questionanswer=" . $answer . "&questionType=3&weight=".$weight);  // FIX ME
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $output = curl_exec($ch);
  $decoded_json = json_decode($output);
  
  echo $output;
  // form variable is probably wrong, not being sent from form but works on cmdline
/*
  if($decoded_json->{"addQuestion"} == "success") {
    $json["message"] = "Successfully added Open Ended question # ".$decoded_json->{"qid"};
  } else if($decoded_json->{"addQuestion"} == "fail") {
    $json["message"] = "Error";
  } else {
    $json["message"] = "Unknown Error";
  }
  curl_close($ch);
 * 
 */
  // Pretending to have processed something.
  //$json["message"] = "Successfully added Open Ended question # ";
  $json["message"] = "ok";
  echo json_encode($json);
}

function newExam() {
    //
    //get a list of tests
    // curl --data "classId=1" http://afsaccess2.njit.edu/~es66/gettest.php
    //return array of tests
    // [{"Id":"0","TestName":"Cs100"},{"Id":"99","TestName":"CSSSS"}]
    
    $ch = curl_init();
    //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/beta/model.php"); // Mock Backend
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/getquestions.php");  // Real Backend
    //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/gettest.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=getQuestions");  // Mock Backend
    curl_setopt($ch, CURLOPT_POSTFIELDS, "classId=0"); // fix me
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    
    $questions = json_decode($output);
    
    //echo $output;
    $json = array();
    for($i = 0;$i < count($questions);$i++) {
        //if statement for weight needed here
        // $questions[$i]->{'Weight'}
        $weight = "Easy";
        //$qtype = $questions[$i]->{'Type'};
        if ($questions[$i]->{'QuestionType'} == '1') {
            $qtype = "Multiple Choice";
        }
        if ($questions[$i]->{'QuestionType'} == '2') {
            $qtype = "True False";
        }
        if ($questions[$i]->{'QuestionType'} == '3') {
            $qtype = "Open Ended";
        }
        
        //$json[] = array('question' => $questions[$i]->{'Question'}, 'qid' => $questions[$i]->{'QuestionID'}, 'weight' => $weight, 'type' => $qtype);
        $json[] = array('question' => $questions[$i]->{'Question'}, 'qid' => $questions[$i]->{'Id'}, 'weight' => $questions[$i]->{'Weight'}, 'type' => $qtype);
    }
      //$decoded_json = json_decode($output);
    //$json = array();
     
    // Once we get the real backend in place here, I need to output something real.
    //echo count($output);
    //$json["message"] = "There are no questions available in the Question Bank";
    // Pretending to have processed something.
    
    /*
    $questionbank = array();
    $questionbank[] = array( "qid" => "1", "question" => "A sample question one");
    $questionbank[] = array( "qid" => "2", "q" => "A sample question two");
    $questionbank[] = array( "qid" => "3", "q" => "A sample question three");
    $questionbank[] = array( "qid" => "4", "q" => "A sample question four"); 
        
    echo json_encode($questionbank);  
     * 
     */ 
    echo json_encode($json);
    //echo json_encode($output);
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
        curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/middle/beta/gettestsubmit.php");
        //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/gettest.php");
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

//function takeExam($exam, $username, $qid) {
function takeExam($poststring) {
    /*
     * Get a list of exams, then
     * Take the exam:
     * curl --data "TestId=100" http://afsaccess2.njit.edu/~es66/gettestquestions.php
     * returns [{"qid":"1","question":"Python is an interpreted language"},{"qid":"2","question":"This is another question"}]
     * 
     * Do another curl : to gettestquestionanswer.php takes a question Id
     * http://afsaccess2.njit.edu/~es66/gettestquestionanswers.php
     * curl --data "questionId=2" http://afsaccess2.njit.edu/~es66/gettestquestionanswers.php
     * Have a loop to get the other values.
     * 
     * front to middle:
     * cmd=takeExam&examName=".$_GET["examName"]."&username=".$_SESSION["user"]."&qid=".$_GET["qid"]."&userid=".$_SESSION['userId']
     */
    $username = $poststring["username"];
    $exam = $poststring["examName"];
    $qid = $poststring["qid"];
    $userid = $poststring["userid"];
    $ch = curl_init();
    
    //echo $qid;
    /*
     * Get my the exam Id
     */
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/gettest.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    
    $examList = json_decode($output);
    //echo $output;
    //echo $examList[2]->{'Id'};
    for($i = 0;$i < count($examList);$i++) {
        if ($examList[$i]->{'TestName'}==$exam) $TestId = $examList[$i]->{'Id'};
    }
    
    /*
     * Get questions from examId
     */
    if($TestId) {
        //echo "found something\n";
        //echo $TestId;
        //echo $userid;
        curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/gettestquestions.php");
        //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/middle/beta/gettestquestions.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "TestId=".$TestId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        //echo $output;
    } else {
        echo "No questions found.";
    }
        
    $json = array();
    //$ch = curl_init();
    ///curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/beta/model.php"); // Mock Backend
    //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/gettestquestions.php");  // Real Backend
    ///curl_setopt($ch, CURLOPT_POST, 1);
    ///curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=takeExam&exam=" . $exam . "&username=" . $username);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=takeExam&exam=" . $exam . "&username=" . $username); // fix me
    ///curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    ///$ch_output = curl_exec($ch);
    
    $questions = json_decode($output);
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
                //$type = $questions[$i]->{"type"};
                $previous = $questions[$i-1]->{"qid"};
                $next = $questions[$i+1]->{"qid"};
            }
        }
    }
    
    /* Check if answer exists */
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/getstudenttest.php");
    //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/getstudenttest.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=getQuestions");
    curl_setopt($ch, CURLOPT_POSTFIELDS, "studentid=" . $userid . "&testid=" . $TestId); // fix me
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $answer_output = curl_exec($ch);
    //echo "studentid=" . $userid . "&testid=" . $TestId;
    //echo $answer_output;
    $answers = json_decode($answer_output);
    
    for($i=0;$i<count($answers);$i++) {
        //echo $answers[$i]->{'studentanswer'};
        if($answers[$i]->{'QuestionId'} == $current) $userAnswer = $answers[$i]->{'studentanswer'};
    }
    
    /* Getting type */
    //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/middle/beta/getqtype.php");
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/getqtype.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "qid=".$current);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $type_output = curl_exec($ch);
    
    //echo $type_output;
    //$json["type"] = $type;
    $var = json_decode($type_output);
    if($var->{'type'}==1) $type = "mc";
    if($var->{'type'}==2) $type = "tf";
    if($var->{'type'}==3) $type = "oe";
    
    $json["type"] = $type;
    $json["question"] = $question;
    $json["current"] = $current;
    $json["previous"] = $previous;
    $json["next"] = $next;
    $json["userAnswer"] = $userAnswer;
    
    //need code to send opts
    
    // Getting options
    if($var->{'type'}==1) {
        //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/middle/beta/getqopts.php");
        curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/getqopts.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "qid=".$current);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $opts_output = curl_exec($ch);
        
        $opts = json_decode($opts_output);
        //echo $opts[1]->{'Opt'};
        
        
        for($i = 0;$i < count($opts);$i++) {
            $json["Opt".$i] = $opts[$i]->{'Opt'};
        } 
         
        
    }
    /*
    $json["Opt1"] = "Fake option 1";
    $json["Opt2"] = "Fake option 2";
    $json["Opt3"] = "Fake option 3";
    $json["Opt4"] = "Fake option 4";
    */
     
    echo json_encode($json);
}

// May not need this function
function updateQuestion($qid,$status,$exam) {
    // Need to retire this function for now, we are going to display a single
    // page for the test taking.
    /* Need code for backend to update the answer to a question */
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/beta/model.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=updateQuestion&exam=" . $exam . "&qid=" . $qid."&status=".$status);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ch_output = curl_exec($ch);
    
    echo $ch_output;
}

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
    echo "in check answer";
///function checkAnswer($qid, $answer, $exam) {
    $json = array();
    $ch = curl_init();

    //echo $qid;
    /*
     * Get my the exam Id
     */
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/gettest.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
   
    $examList = json_decode($output);
    echo "CCCCCC";    
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
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/addstudenttest.php");
    //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/addstudenttest.php");
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
// Do I really need this? Yes I do
function examScores($username) {
    
    // Query the scores table;
    // get a return of all the values.
    /*
    $ch = curl_init();
    //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/beta/model.php");
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/gettestquestions.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=getQuestions");
    curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=getQuestions"); // fix me
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $decoded_json = json_decode($output);
     * 
     */
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/middle/beta/getstudents.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    //echo $output;
    $students = json_decode($output);
    for($i=0;$i<count($students);$i++) {
        //get testid
        //http://afsaccess2.njit.edu/~ls339/cs490/back/getstudenttestsubmit.php
        //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/getstudenttestsubmit.php");
        curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/getstudenttestsubmit.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "studentid=".$students[$i]->{'UserId'});
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        //echo $output;
        $testId = json_decode($output);
        //echo count($testId);
        for($j=0;$j<count($testId);$j++){
            //echo "testing";
            //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/getstudenttest.php");
            curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/getstudenttest.php");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "studentid=".$students[$i]->{'UserId'}."&testid=".$testId[$j]->{'TestId'});
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            $testresults = json_decode($output);
            $score = 0;
            //echo $output;
            echo "studentid=".$students[$i]->{'UserId'}."&testid=".$testId[$j]->{'TestId'};
            //echo count($testresults);
            for($k=0;$k<count($testresults);$k++){
                //echo $testresults[$k]->{'studentanswer'};
                if($testresults[$k]->{'studentanswer'}==$testresults[$k]->{'correctanswer'}) {
                    $score = $score + $testresults[$k]->{'weight'};
                }
            }
            //echo count($testresults);
            $score = ( $score / count($testresults) ) ;
            //Display the Exam Name instead of Id
            curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/gettest.php");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            $testlist = json_decode($output);
            for($k=0;$k<count($testlist);$k++){
                if($testlist[$k]->{'Id'} == $testId[$j]->{'TestId'}) {
                    $exam = $testlist[$k]->{'TestName'};
                }
            }
            //Need to get release status here
            curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/getstudenttestsubmit.php");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "studentid=" . $students[$i]->{'UserId'});
            $output = curl_exec($ch);
            $teststatus = json_decode($output);
            //echo $output;
            //echo "ScoreRelease = ".$teststatus[0]->{'ScoreRelease'}."<--";
            
            for($k=0;$k<count($teststatus);$k++) {
                if($teststatus[$k]->{'TestId'}==$testId[$j]->{'TestId'}) $releaseStatus = $teststatus[$k]->{'ScoreRelease'};
            }
            $json[] = array('name'=>$students[$i]->{'FirstName'}." ".$students[$i]->{'LastName'},"releaseStatus" => $releaseStatus,'exam' => $exam, 'score' => $score, 'studentId' => $students[$i]->{'UserId'},'examId' => $testId[$j]->{'TestId'});
            //$json[] = array('name'=>$students[$i]->{'FirstName'}." ".$students[$i]->{'LastName'},"releaseStatus" => $students[$i]->{'ScoreRelease'},'exam' => $exam, 'score' => $score );
        }
        
        // Get studenttest
        //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/getstudenttest.php");
        //curl_setopt($ch, CURLOPT_POST, 1);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, "studentid=".$students[$i]->{'FirstName'}."&testid=".
        
        
        //$json[] = array('name'=>$students[$i]->{'FirstName'}." ".$students[$i]->{'LastName'});
    }
    // Pretend to send json object
    //echo json_encode(array(array("exam" => "Exam1","score" => "70%"),array("exam" => "Final","score" => "80%",)));
    echo json_encode($json);
    //echo json_encode(array(array("name" => "Jack", "exam" => "Exam1","score" => "70%","releaseStatus" => "0"),array("name" => "Jill", "exam" => "Final","score" => "80%","releaseStatus" => "1")));
}
// Do I really need this? Yes I do
function getScores($userId) {
    
    //echo $userId;
    $json = array();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/getstudenttestsubmit.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "studentid=" . $userId);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    //echo $output;
    $testsubmit = json_decode($output);
    //echo count($testsubmit);
    for($i=0;$i<count($testsubmit);$i++){
        //echo test;
        //Display the Exam Name instead of Id
        //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/gettest.php");
        curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/gettest.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        //echo $output;
        $testlist = json_decode($output);
        for ($j = 0; $j < count($testlist); $j++) {
            if ($testlist[$j]->{'Id'} == $testsubmit[$i]->{'TestId'}) {
                $exam = $testlist[$j]->{'TestName'};
            }
        }
        //echo $exam;
        //echo $testsubmit[$i]->{'ScoreRelease'};
        if($testsubmit[$i]->{'ScoreRelease'}==1) {
            // Calculate Score
            curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/getstudenttest.php");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "studentid=".$userId."&testid=".$testsubmit[$i]->{'TestId'});
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            $testresults = json_decode($output);
            $score = 0;
            //echo "----".$output."-----";
            for ($k = 0; $k < count($testresults); $k++) {
                //echo $testresults[$k]->{'studentanswer'};
                //echo $testresults[$k]->{'correctanswer'};
                //echo $testresults[$k]->{'weight'};
                if ($testresults[$k]->{'studentanswer'} == $testresults[$k]->{'correctanswer'}) {
                    $score = $score + $testresults[$k]->{'weight'};
                }
            }
            
            $score = ( $score / count($testresults) ) ;
            //echo $testsubmit[$i]->{'ScoreRelease'};
            $json[] = array('exam' => $exam, 'score' => $score);
        }
        //$json[] = array('exam' => $exam, );
    }
    //echo $json[0]["score"];
    curl_close($ch);
    //echo $json_encode($json);
    /*
    $ch = curl_init();
    //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/beta/model.php");
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/gettestquestions.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=getQuestions");
    curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=getQuestions"); // fix me
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $decoded_json = json_decode($output);
    */
    echo json_encode($json);
    // Pretend to send json object
    //echo json_encode(array(array("exam" => "Exam1","score" => "70%"),array("exam" => "Final","score" => "80%",)));
    //echo json_encode(array(array("name" => "Jack", "exam" => "Exam1","score" => "70%","releaseStatus" => "0"),array("name" => "Jill", "exam" => "Final","score" => "80%","releaseStatus" => "1")));
}

// FIX THIS
function ReleaseScore($poststring) {
    
    
    /*
    $ch = curl_init();
    //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/beta/model.php");
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/gettestquestions.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=getQuestions");
    curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=getQuestions"); // fix me
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $decoded_json = json_decode($output);
    */
    
    // Nee to point this to backend
    $ch = curl_init();
    //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/getstudenttestsubmit.php");
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/studentscorerelease.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "studentid=" . $poststring['studentId']."&testid=".$poststring['examId']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    //$testId = json_decode($output);
    //echo $output;
    //echo "studentid=" . $poststring['studentId']."&testid=".$poststring['examId'];
    //echo "ok in function ReleaseScore";
    //echo 
    // Pretend to send json objectname" => "Jack", "exam" => "Exam1","score" => "70%","releaseStatus" => "0"),array("name" => "Jill", "exam" => "Final","score" => "80%","releaseStatus" => "1")));
}

// For features
function getStudents() {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/middle/beta/getstudents.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    echo $output;
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
        newExam();
        break;
    case "createExam":
        createExam($_POST);
        //echo count($_POST);
        break;
    case "getExams":
        getExams($_POST['userId']);
        break;
    case "takeExam":
        //takeExam($_POST["exam"],$_POST["username"],$_POST["qid"]);
        takeExam($_POST);
        break;
    case "checkAnswer":
        //checkAnswer($_POST["qid"],$_POST["answer"],$_POST["exam"]);
        //checkAnswer($_POST);
        echo "in SWITCH";
        break;
    case "submitExam":
        submitExam($_POST);
        break;
    case "examScores":
        examScores($_POST["username"]);
        break;
//    case "getScores":
//        getScores($_POST["username"]);
//        break;
    case "getScores":
        getScores($_POST["userId"]);
        break;
    case "releaseScore":
        releaseScore($_POST);
        break;
    case "getStudents":
        getStudents();
        break;
    default:
        echo "You need to send me a command, for example: cmd = auth ";
}
 
?>