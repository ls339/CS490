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
        $json["firstname"] = $decoded_json->{"firstname"};
        $json["lastname"] = $decoded_json->{"lastname"};
    } else {
        $json["login"] = "bad";
    }
    curl_close($ch);
    echo json_encode($json);
}

function addTFQuestion($question, $answer) {
    $json = array();
    $ch = curl_init();
    //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/beta/model.php"); // Mock Backend
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/addquestions.php"); // Real Backend
    curl_setopt($ch, CURLOPT_POST, 1);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=addTFQuestion&question=".$question."&answer=".$answer); // Mock Backend
    curl_setopt($ch, CURLOPT_POSTFIELDS, "questionName=" . $question . "&answer=" . $answer . "&questionType=2");  // Real Backend
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
    $json["message"] = "Successfully added True | False question";
    echo json_encode($json);

}

function addMCQuestion($poststring) {
    $question = $poststring["Question"];
    $answer = $poststring["answer"];
    $options = array($poststring["Opt1"],$poststring["Opt2"],$poststring["Opt3"],$poststring["Opt4"]);
    $json = array();
    //$datastring = "questionName=" . $question . "&answer=" . $answer . "&questionType=1&Opt1=".$options[1]."&Opt2=".$options[2]."&Opt3=".$options[3]."&Opt4=".$options[4]; 
    //echo $datastring;
    //echo "questionName=" . $question . "&answer=" . $answer . "&questionType=1&Opt1=".$options[1]."&Opt2=".$options[2]."&Opt3=".$options[3]."&Opt4=".$options[4]"
    
    $ch = curl_init();
    //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/beta/model.php");
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/addquestions.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=addTFQuestion&question=".$question."&answer=".$answer);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "questionName=" . $question . "&answer=" . $answer . "&questionType=1&Opt1=".$options[1]."&Opt2=".$options[2]."&Opt3=".$options[3]."&Opt4=".$options[4]);  // FIX ME
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
    curl_close($ch);
 
 */
    // Pretending to have processed something.
    $json["message"] = "Successfully added MC question";
    echo json_encode($json);
}

function addOEQuestion($question,$answer) {

  //echo $question."<br>";
  //echo $answer."<br>";    
  $json = array();
  $ch = curl_init();
  //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/beta/model.php");
  curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/addquestions.php");
  curl_setopt($ch, CURLOPT_POST, 1);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=addOEQuestion&question=".$question."&answer=".$answer);
  curl_setopt($ch, CURLOPT_POSTFIELDS, "questionName=" . $question . "&answer=" . $answer . "&questionType=3");  // FIX ME
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $output = curl_exec($ch);
  $decoded_json = json_decode($output);
  
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
  $json["message"] = "Successfully added Open Ended question # ";
  echo json_encode($json);
}

function newExam() {

    $ch = curl_init();
    //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/beta/model.php"); // Mock Backend
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/getquestions.php");  // Real Backend
    curl_setopt($ch, CURLOPT_POST, 1);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=getQuestions");  // Mock Backend
    curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=test"); // fix me
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
 
    
      //$decoded_json = json_decode($output);
      //$json = array();
     
    // Once we get the real backend in place here, I need to output something real.
    echo count($output);
    // Pretending to have processed something.
      /*
    $questionbank = array();
    $questionbank[] = array( "qid" => "1", "q" => "A sample question one");
    $questionbank[] = array( "qid" => "2", "q" => "A sample question two");
    $questionbank[] = array( "qid" => "3", "q" => "A sample question three");
    $questionbank[] = array( "qid" => "4", "q" => "A sample question four"); 
       * 
       */
    //echo json_encode($questionbank);;
}

function createExam($poststring) {
    $json = array();
    if($poststring["ExamName"] == "") {
        $json["status"] = "fail";
        $json["message"] = "You must provide an exam name!";
    // Need to fix logic on how to tell if no questions were selected.
    //} else if ($poststring["q0"] == "") {
    //    $json["status"] = "fail";
    //    $json["message"] = "There must be at least one question selected!";
    } else {
        
        $ch = curl_init();
        //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/beta/model.php");  // Mock Backend
        curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/addtest.php");  // Real Backend
        curl_setopt($ch, CURLOPT_POST, 1);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $poststring);  // Mock Backend
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datastring);  // FIX ME
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        
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

function getExams() {
    $json = array();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/beta/model.php"); // Mock Backend
    //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/gettest.php"); // Real Backend
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=getExams");  // Mock Backend
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=getExams"); // Real Backend
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ch_output = curl_exec($ch);
    $decoded_output = json_decode($ch_output);
    for($i = 0; $i < count($decoded_output); $i++) {
        $json[] = array("exam" => substr($decoded_output[$i]->{"exam"},11));
    }
    echo json_encode($json);
}

//function takeExam($exam, $username, $qid) {
function takeExam($poststring) {
    $username = $poststring["username"];
    $exam = $poststring["examName"];
    $qid = $poststring["qid"];
    $json = array();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/beta/model.php"); // Mock Backend
    //curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/gettestquestions.php");  // Real Backend
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=takeExam&exam=" . $exam . "&username=" . $username);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=takeExam&exam=" . $exam . "&username=" . $username); // fix me
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ch_output = curl_exec($ch);
    $questions = json_decode($ch_output);
    $count = count($questions);
    if ($qid == "") {
        $question = $questions[0]->{"question"};
        $current = $questions[0]->{"qid"};
        $type = $questions[0]->{"type"};
        $next = $questions[1]->{"qid"};
    } else {
        for ($i = 0; $i < $count; $i++) {
            if($qid == $questions[$i]->{"qid"}) {
                $question = $questions[$i]->{"question"};
                $current = $questions[$i]->{"qid"};
                $type = $questions[$i]->{"type"};
                $previous = $questions[$i-1]->{"qid"};
                $next = $questions[$i+1]->{"qid"};
            }
        }
    }
    $json["type"] = $type;
    $json["question"] = $question;
    $json["current"] = $current;
    $json["previous"] = $previous;
    $json["next"] = $next;
    echo json_encode($json);
}

function updateQuestion($qid,$status,$exam) {
    /* Need code for backend to update the answer to a question */
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/beta/model.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=updateQuestion&exam=" . $exam . "&qid=" . $qid."&status=".$status);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ch_output = curl_exec($ch);
    
    echo $ch_output;
}

function checkAnswer($qid, $answer, $exam) {
    $json = array();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~ls339/cs490/back/beta/model.php");
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/gettestquestions.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=getQuestions");
    curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=getQuestions"); // fix me
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $decoded_json = json_decode($output);
  
    //echo count($decoded_json);
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
    //echo "input qid ".$qid."<br>";
    //echo "input answer ".$answer."<br>";
    //echo "db answer ".$db_answer."<br>";
    $json["qid"] = $qid;
    $json["yourAnswer"] = $answer;
    $json["realAnswer"] = $db_answer;
    $json["result"] = $result;
    
    echo json_encode($json);
}

function examScores($username) {
    
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
    // Pretend to send json object
    //echo json_encode(array(array("exam" => "Exam1","score" => "70%"),array("exam" => "Final","score" => "80%",)));
    echo json_encode(array(array("name" => "Jack", "exam" => "Exam1","score" => "70%","releaseStatus" => "0"),array("name" => "Jill", "exam" => "Final","score" => "80%","releaseStatus" => "1")));
}

function getScores($username) {
    
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
    // Pretend to send json object
    echo json_encode(array(array("exam" => "Exam1","score" => "70%"),array("exam" => "Final","score" => "80%",)));
    //echo json_encode(array(array("name" => "Jack", "exam" => "Exam1","score" => "70%","releaseStatus" => "0"),array("name" => "Jill", "exam" => "Final","score" => "80%","releaseStatus" => "1")));
}

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
    echo "ok in function ReleaseScore";
    // Pretend to send json objectname" => "Jack", "exam" => "Exam1","score" => "70%","releaseStatus" => "0"),array("name" => "Jill", "exam" => "Final","score" => "80%","releaseStatus" => "1")));
}

/* Main */
switch ($_POST["cmd"]) {
    case "auth":
        auth($_POST["username"], $_POST["password"]);
        break;
    case "addTFQuestion":
        addTFQuestion($_POST["Question"], $_POST["Answer"]);
        break;
    case "addMCQuestion":
        addMCQuestion($_POST);
        break;
    case "addOEQuestion":
        addOEQuestion($_POST["Question"], $_POST["Answer"]);
        break;
    case "newExam":
        newExam();
        break;
    case "createExam":
        createExam($_POST);
        break;
    case "getExams":
        getExams();
        break;
    case "takeExam":
        //takeExam($_POST["exam"],$_POST["username"],$_POST["qid"]);
        takeExam($_POST);
        break;
    case "checkAnswer":
        checkAnswer($_POST["qid"],$_POST["answer"],$_POST["exam"]);
        break;
    case "examScores":
        examScores($_POST["username"]);
        break;
    case "getScores":
        getScores($_POST["username"]);
        break;
    case "releaseScore":
        releaseScore($_POST);
        break;
    default:
        echo "You need to send me a command, for example: cmd = auth ";
} 
?>