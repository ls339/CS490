#!/bin/sh
#
# ls339
# Script to test that the "middle" curl requests
# are returning properly

QUESTION=$2
ANSWER=$3

if [ $1 == "remote" ]; then
  #url="http://afsaccess2.njit.edu/~ls339/cs490/middle/proc.php"
  url="http://afsaccess2.njit.edu/~es66/addquestions.php"
elif [ $1 == "local" ]; then
  url="http://afsaccess2.njit.edu/~es66/addquestions.php"
  #url="http://afsaccess2.njit.edu/~ls339/cs490/middle/proc.php"
  #url="http://web.njit.edu/~ls339/cs490/middle/proc.php"
else 
  echo "provide a location"
  exit 1
fi


CMD=( 
    auth 
    addTFQuestion 
    addMCQuestion 
    addOEQuestion 
    newExam 
    createExam 
    getExas 
    takeExam 
    updateQuestion 
    checkAnswer 
    examScores
)

count=${#CMD[@]}

#for((i=0;i<count;i++)) 
#  do
#    echo ${CMD[$i]}
#  done

data="cmd=${CMD[1]}&questionName=${QUESTION}&questionType=2&answer=${ANSWER}"
echo ${CMD[0]} "Output : "
curl --data "$data" $url

#echo $data
