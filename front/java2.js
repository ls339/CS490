function myFunction() {
    var password = document.getElementById("password").value;
    var username = document.getElementById("username").value;

    if (username == '' ||  password == '') {
        alert("Please Fill All Fields");
    } else {
        //document.getElementById("output").innerHTML= username;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById("output").innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("POST","cetch.php",true);
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xmlhttp.send("username="+username+"&password="+password);
    }
}
function finalSubmit() {
    var examName = document.getElementById("examName").value;
    var user = document.getElementById("user").value;
    var userId = document.getElementById("userId").value;
    var answered = document.getElementById("answered").value;
    var total = document.getElementById("total").value;
    var cmd = document.getElementById("cmd").value;
    if (answered != total) {
        if(confirm("Your are about to submit the quiz with unanswered questions do you wish to continue?")){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function ()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                window.location='quizList.php';
            }
        }
        xmlhttp.open("POST", "finalSubmit.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("examName=" + examName + "&user=" + user + "&userId=" + userId + "&cmd=" + cmd);
    }}else{
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function ()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                window.location='quizList.php';
            }
        }
        xmlhttp.open("POST", "finalSubmit.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("examName=" + examName + "&user=" + user + "&userId=" + userId + "&cmd=" + cmd);
    }
}

function addToQuiz() {
    var qidList = document.getElementsByName("qid");
    //var qid = document.getElementById("qid_").value;
    var form = document.getElementById('newExamForm');
    for (var i = 0, length = qidList.length; i < length; i++) {
        if(qidList[i].checked) {
	    var qid = qidList[i].value;
	}
        //form.insertAdjacentHTML('afterbegin','<input type="checkbox" name="qid[]" value="'+ qid +'" checked>'+ qid +'<br>');
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST","getQuestion.php",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("cmd=getQuestion&qid="+qid);
    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            form.insertAdjacentHTML('afterbegin','<input type="checkbox" name="qid[]" value="'+ qid +'" checked>'+ xmlhttp.responseText +'<br>');
        }
    }
    
    //form.insertAdjacentHTML('afterbegin','test<br>');
    //form.insertAdjacentHTML('afterbegin','<input type="checkbox" name="qid[]" value="'+ qid +'" checked>'+ qid +'<br>');
//document.getElementById("newExam").appendChild=qid;
/*
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("newExam").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("POST","cetch.php",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("username="+username+"&password="+password);
    */
   
}
