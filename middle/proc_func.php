<?php
 
function isSubmitted($userId,$examId) {
    
    return true;
}

function getExamId($examName) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/gettest.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $exams = json_decode($output);
    
    for($i=0;$i<count($exams);$i++) {
        if($exams[$i]->{'TestName'}==$examName) $examId = $exams[$i]->{'Id'};
    }
    curl_close($ch);
    return $examId;
}

function getQuestion($qid) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/getquestions.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $questions = json_decode($output);
    
    for($i=0;$i<count($questions);$i++) {
        if($questions[$i]->{'Id'}==$qid) $question = $questions[$i]->{'Question'};
    }
    curl_close($ch);
    return $question;
}

function getMCQuestionAnswer($answer,$qid) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/getqopts.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "qid=".$qid);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $opts = json_decode($output);
    
    /* The number of options is hardcoded to 4 */
    if($answer=="A") $opt = $opts[0]->{'Opt'};
    if($answer=="B") $opt = $opts[1]->{'Opt'};
    if($answer=="C") $opt = $opts[2]->{'Opt'};
    if($answer=="D") $opt = $opts[3]->{'Opt'};
    /*
    for($i=0;$i<count($opts);$i++) {
        
    }
     * 
     */
    /*
    for($i=0;$i<count($questions);$i++) {
        if($questions[$i]->{'Id'}==$qid) $question = $questions[$i]->{'Question'};
    }
     * 
     */
    curl_close($ch);
    return $opt;
}

function getQuestionType($qid) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/getquestions.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $questions = json_decode($output);
    
    for($i=0;$i<count($questions);$i++) {
        if($questions[$i]->{'Id'}==$qid) $type = $questions[$i]->{'QuestionType'};
    }
    curl_close($ch);
    if($type==1) $qtype = "Multiple Choice";
    if($type==2) $qtype = "True False";
    if($type==3) $qtype = "Fill in the blank";
    return $qtype;
}

function calculateScore($userId, $testId) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://afsaccess2.njit.edu/~es66/getstudenttest.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "studentid=" . $userId . "&testid=" . $testId);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $testresults = json_decode($output);

    /* Get student score */
    $studentScore = 0;
    for ($k = 0; $k < count($testresults); $k++) {
        if ($testresults[$k]->{'studentanswer'} == $testresults[$k]->{'correctanswer'}) {
            $studentScore = $studentScore + $testresults[$k]->{'weight'};
        }
    }

    /* Get max score */
    $maxScore = 0;
    for ($k = 0; $k < count($testresults); $k++) {
        $maxScore = $maxScore + $testresults[$k]->{'weight'};
    }
    curl_close($ch);
    return $score = round(($studentScore / $maxScore) * 100) . "%";
}