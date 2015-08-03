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
