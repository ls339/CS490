<?php
    ob_start();
    session_start();
    if(!isset($_SESSION['teacher']))header('Location: index.php');
    include('thead.php');
?>
<center><div class="alert alert-success">
		    <h2>Welcome Professor <?php echo $_SESSION['firstName']." ".$_SESSION['lastName']; ?> !!</h2>
    </div></center>
    </div>

