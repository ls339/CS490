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