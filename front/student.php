<?php
     ob_start();
    session_start();
    if(!isset($_SESSION['student']))header('Location: index.php');
    include('studentHeader.php');
?>
<center><div class="alert alert-success">
		    <h1>Welcome Student <?php echo $_SESSION['firstName']." ".$_SESSION['lastName']; ?> !!</h1>
                    <img src="media/python-logo.png">
    </div></center>
    </div>

