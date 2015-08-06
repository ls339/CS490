<?php

/* 
 * ls339
 * proc_func.php
 * Final Version
 */

function isSubmitted($userId,$examId) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/gettestsubmit.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "userid=".$userId."&testid=".$examId);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $testStatus = json_decode($output);
    curl_close($ch);
    if($testStatus->{'Submitted'} == '1') {
        return true;
    } else {
        return false;
    }
}

function getExamId($examName) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/gettest.php");
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

function getExamName($examId) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/gettest.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $exams = json_decode($output);
    
    for($i=0;$i<count($exams);$i++) {
        if($exams[$i]->{'Id'}==$examId) $examName = $exams[$i]->{'TestName'};
    }
    curl_close($ch);
    return $examName;
}

function getQuestion($qid) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/getquestions.php");
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

function getQuestionWeight($qid) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/getquestions.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $questions = json_decode($output);
    
    for($i=0;$i<count($questions);$i++) {
        if($questions[$i]->{'Id'}==$qid) $weight = $questions[$i]->{'Weight'};
    }
    curl_close($ch);
    return $weight;
}

function getMCQuestionAnswer($answer,$qid) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/getqopts.php");
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

    curl_close($ch);
    return $opt;
}

function getMCOptions($qid) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/getqopts.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "qid=".$qid);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function getQuestionType($qid) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/getquestions.php");
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

function getQuestionList() {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/getquestions.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "classId=0");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $questions = json_decode($output);
    $json = array();

    for ($i = 0; $i < count($questions); $i++) {
        curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/getquestionanswers.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "questionId=" . $questions[$i]->{'Id'});
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $questionAnswers = json_decode($output);


        if ($questions[$i]->{'QuestionType'} == '1') {
            $qtype = "Multiple Choice";
        }
        if ($questions[$i]->{'QuestionType'} == '2') {
            $qtype = "True False";
        }
        if ($questions[$i]->{'QuestionType'} == '3') {
            $qtype = "Fill in the blank";
        }
        $json[] = array('question' => $questions[$i]->{'Question'}, 'qid' => $questions[$i]->{'Id'}, 'weight' => $questions[$i]->{'Weight'}, 'type' => $qtype);
    }
    curl_close($ch);
    return json_encode($json);
}

function calculateScore($userId, $testId) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~es66/getstudenttest.php");
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

function sortQuestions($json, $type, $weight) {
    $questions = json_decode($json);
    $json = array();
    
    if ($type == "All" && $weight == "All") {
        return json_encode($questions);

    }   
    
    if ($type == "" && $weight == "") {
        return json_encode($questions);

    }
    
    if ($type == "All" && $weight == "Easy") {
        for ($i = 0; $i < count($questions); $i++) {
            if ($questions[$i]->{"weight"} == "1") {
                $json[] = array('qid' => $questions[$i]->{'qid'}, 'question' => $questions[$i]->{'question'}, 'type' => $questions[$i]->{'type'}, 'weight' => $questions[$i]->{'weight'});
            }
        }
    }

    if ($type == "All" && $weight == "Medium") {
        for ($i = 0; $i < count($questions); $i++) {
            if ($questions[$i]->{"weight"} == "2") {
                $json[] = array('qid' => $questions[$i]->{'qid'}, 'question' => $questions[$i]->{'question'}, 'type' => $questions[$i]->{'type'}, 'weight' => $questions[$i]->{'weight'});
            }
        }
    }
    
    if ($type == "All" && $weight == "Hard") {
        for ($i = 0; $i < count($questions); $i++) {
            if ($questions[$i]->{"weight"} == "3") {
                $json[] = array('qid' => $questions[$i]->{'qid'}, 'question' => $questions[$i]->{'question'}, 'type' => $questions[$i]->{'type'}, 'weight' => $questions[$i]->{'weight'});
            }
        }
    }    
    
    if ($type == "True False" && $weight == "All") {
        for ($i = 0; $i < count($questions); $i++) {
            if ($questions[$i]->{"type"} == "True False") {
                $json[] = array('qid' => $questions[$i]->{'qid'}, 'question' => $questions[$i]->{'question'}, 'type' => $questions[$i]->{'type'}, 'weight' => $questions[$i]->{'weight'});
            }
        }
    }
    
    if ($type == "True False" && $weight == "Easy") {
        for ($i = 0; $i < count($questions); $i++) {
            if ($questions[$i]->{"type"} == "True False" &&  $questions[$i]->{"weight"} == '1') {
                $json[] = array('qid' => $questions[$i]->{'qid'}, 'question' => $questions[$i]->{'question'}, 'type' => $questions[$i]->{'type'}, 'weight' => $questions[$i]->{'weight'});
            }
        }
    }
    
    if ($type == "True False" && $weight == "Medium") {
        for ($i = 0; $i < count($questions); $i++) {
            if ($questions[$i]->{"type"} == "True False" &&  $questions[$i]->{"weight"} == '2') {
                $json[] = array('qid' => $questions[$i]->{'qid'}, 'question' => $questions[$i]->{'question'}, 'type' => $questions[$i]->{'type'}, 'weight' => $questions[$i]->{'weight'});
            }
        }
    }
    
    if ($type == "True False" && $weight == "Hard") {
        for ($i = 0; $i < count($questions); $i++) {
            if ($questions[$i]->{"type"} == "True False" &&  $questions[$i]->{"weight"} == '3') {
                $json[] = array('qid' => $questions[$i]->{'qid'}, 'question' => $questions[$i]->{'question'}, 'type' => $questions[$i]->{'type'}, 'weight' => $questions[$i]->{'weight'});
            }
        }
    }
    
    if ($type == "Multiple Choice" && $weight == "All") {
        for ($i = 0; $i < count($questions); $i++) {
            if ($questions[$i]->{"type"} == "Multiple Choice") {
                $json[] = array('qid' => $questions[$i]->{'qid'}, 'question' => $questions[$i]->{'question'}, 'type' => $questions[$i]->{'type'}, 'weight' => $questions[$i]->{'weight'});
            }
        }
    }      
   
    if ($type == "Multiple Choice" && $weight == "Easy") {
        for ($i = 0; $i < count($questions); $i++) {
            if ($questions[$i]->{"type"} == "Multiple Choice" &&  $questions[$i]->{"weight"} == '1') {
                $json[] = array('qid' => $questions[$i]->{'qid'}, 'question' => $questions[$i]->{'question'}, 'type' => $questions[$i]->{'type'}, 'weight' => $questions[$i]->{'weight'});
            }
        }
    }

    if ($type == "Multiple Choice" && $weight == "Medium") {
        for ($i = 0; $i < count($questions); $i++) {
            if ($questions[$i]->{"type"} == "Multiple Choice" &&  $questions[$i]->{"weight"} == '2') {
                $json[] = array('qid' => $questions[$i]->{'qid'}, 'question' => $questions[$i]->{'question'}, 'type' => $questions[$i]->{'type'}, 'weight' => $questions[$i]->{'weight'});
            }
        }
    } 
    
    if ($type == "Multiple Choice" && $weight == "Hard") {
        for ($i = 0; $i < count($questions); $i++) {
            if ($questions[$i]->{"type"} == "Multiple Choice" &&  $questions[$i]->{"weight"} == '3') {
                $json[] = array('qid' => $questions[$i]->{'qid'}, 'question' => $questions[$i]->{'question'}, 'type' => $questions[$i]->{'type'}, 'weight' => $questions[$i]->{'weight'});
            }
        }
    }

    if ($type == "Fill in the blank" && $weight == "All") {
        for ($i = 0; $i < count($questions); $i++) {
            if ($questions[$i]->{"type"} == "Fill in the blank") {
                $json[] = array('qid' => $questions[$i]->{'qid'}, 'question' => $questions[$i]->{'question'}, 'type' => $questions[$i]->{'type'}, 'weight' => $questions[$i]->{'weight'});
            }
        }
    }      
   
    if ($type == "Fill in the blank" && $weight == "Easy") {
        for ($i = 0; $i < count($questions); $i++) {
            if ($questions[$i]->{"type"} == "Fill in the blank" &&  $questions[$i]->{"weight"} == '1') {
                $json[] = array('qid' => $questions[$i]->{'qid'}, 'question' => $questions[$i]->{'question'}, 'type' => $questions[$i]->{'type'}, 'weight' => $questions[$i]->{'weight'});
            }
        }
    }

    if ($type == "Fill in the blank" && $weight == "Medium") {
        for ($i = 0; $i < count($questions); $i++) {
            if ($questions[$i]->{"type"} == "Fill in the blank" &&  $questions[$i]->{"weight"} == '2') {
                $json[] = array('qid' => $questions[$i]->{'qid'}, 'question' => $questions[$i]->{'question'}, 'type' => $questions[$i]->{'type'}, 'weight' => $questions[$i]->{'weight'});
            }
        }
    } 
    
    if ($type == "Fill in the blank" && $weight == "Hard") {
        for ($i = 0; $i < count($questions); $i++) {
            if ($questions[$i]->{"type"} == "Fill in the blank" &&  $questions[$i]->{"weight"} == '3') {
                $json[] = array('qid' => $questions[$i]->{'qid'}, 'question' => $questions[$i]->{'question'}, 'type' => $questions[$i]->{'type'}, 'weight' => $questions[$i]->{'weight'});
            }
        }
    }      
    return json_encode($json);
}
