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

function addToQuiz(x) {
    //var qidList = document.getElementsByName("qid");
    //var qid = document.getElementById("qid_").value;
    var form = document.getElementById('newExamForm');
    /*var qid = Array();
     for (var i = 0, length = qidList.length; i < length; i++) {
     if(qidList[i].checked) {
     //var qid = qidList[i].value;
     qid.push(qidList[i].value);
     }
     //form.insertAdjacentHTML('afterbegin','<input type="checkbox" name="qid[]" value="'+ qid +'" checked>'+ qid +'<br>');
     }*/
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "getQuestion.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //xmlhttp.send("cmd=getQuestion&qid="+qid);
    xmlhttp.send("cmd=getQuestion&qid=" + x);
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            //for(var i = 0, length = qid.length; i < length; i++){
            form.insertAdjacentHTML('afterbegin', '<input type="checkbox" name="qid[]" value="' + x + '" checked>' + xmlhttp.responseText + '<br>');
            //}
        }
    }
}

   function filterb() {
    var type = document.getElementById("type").value;
    var weight = document.getElementById('weight').value;
    var table = document.getElementById('questionList');
    //document.getElementById("qList").innerHTML="cmd=newExam&weight="+weight+"&type="+type;
    
    /*
    for (var i = 0, length = type.length; i < length; i++) {
        if (type[i].checked) {
            var filter_type = type[i].value;
        }
    }
    */
    
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var obj = JSON.parse(xmlhttp.responseText);
            //getQuestionList(obj);
        //var json = xmlhttp.responseText;
        //var questions = JSON.parse(json);
        //var i;
        var output = "";

            for(i = 0, length = obj.length;i < length; i++) {
                //output = i;
                //output += "<tr><td><input type=\"checkbox\" onClick=\"addToQuiz()\" name=\"qid\" id=\"qid\" value=\""+obj[i].qid+"\"></td><td>"+obj[i].question+"</td><td>"+obj[i].weight+"</td><td>"+obj[i].type+"</td></tr>";
                output += "<tr><td><input type=\"checkbox\" onchange=\"addToQuiz("+obj[i].qid+")\" name=\"qid\" id=\"qid\" value=\""+obj[i].qid+"\"></td><td>"+obj[i].question+"</td><td>"+obj[i].weight+"</td><td>"+obj[i].type+"</td></tr>";
            }
            
        //obj = JSON.parse(xmlhttp.responseText);
        //form.insertAdjacentHTML('afterbegin', '<input type="checkbox" name="qid[]" value="' + qid + '" checked>' + xmlhttp.responseText + '<br>');
        document.getElementById("qList").innerHTML=output;
        }


    //table.insertAdjacentHTML('beforeend','<tr><td>'+type+'</td></tr>');
    //document.getElementById("qList").innerHTML="<tr><td>"+weight+"</td></tr>";

    }
    xmlhttp.open("POST", "getQuestion.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("cmd=newExam&weight="+weight+"&type="+type);

    
}
