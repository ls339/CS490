<?php
     ob_start();
    session_start();
    if(!isset($_SESSION['student']))header('Location: index.html');
    include('studentHeader.php');
?>
<center><div class="alert alert-success">
		    <h1>Welcome Student!</h1>
    </div></center>
    </div>

