#!/bin/sh
#
# ls339
# Script to test that the "middle" curl requests
# are returning properly

USERNAME=$2
PASSWORD=$3

#if [ $1 == "remote" ]; then
#  #url="http://afsaccess2.njit.edu/~ls339/cs490/middle/proc.php"
#  url="http://web.njit.edu/~ls339/cs490/middle/proc.php"
#elif [ $1 == "local" ]; then
#  url="http://afsaccess2.njit.edu/~ls339/cs490/middle/proc.php"
#  #url="http://web.njit.edu/~ls339/cs490/middle/proc.php"
#else 
#  echo "provide a location"
#  exit 1
#fi

function auth() {
#if [ $1 = "authTeacher" ]; then
dataString="user=theo&password=secret00";
url=http://afsaccess2.njit.edu/~es66/login.php
echo "Post String : ${dataString}"
echo "Url : ${url}"
curl --data $dataString $url
echo ""
#fi
echo "-"
#if [ $1 = "authStudent" ]; then
dataString="user=user1&password=pass1";
url=http://afsaccess2.njit.edu/~es66/login.php
echo "Post String : ${dataString}"
echo "Url : ${url}"
curl --data $dataString $url
echo ""
#fi
}


auth

#CMD=( 
#    auth 
#    addTFQuestion 
#    addMCQuestion 
#    addOEQuestion 
#    newExam 
#    createExam 
#    getExas 
#    takeExam 
#    updateQuestion 
#    checkAnswer 
#    examScores
#)

#count=${#CMD[@]}

#for((i=0;i<count;i++)) 
#  do
#    echo ${CMD[$i]}
#  done

#data="cmd=${CMD[0]}&username=${USERNAME}&password=${PASSWORD}"
#echo ${CMD[0]} "Output : "
#curl --data "$data" $url
