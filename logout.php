<?php
	if(!isset($_SESSION)){ session_start();}//session_start();
	session_destroy();
    session_unset();
    
    echo "<script>window.location.href = 'index.php';</script>";

?>