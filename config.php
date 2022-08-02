<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */

if(!isset($_SESSION)){ session_start();}
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');


//if (($_SESSION['campus']=='9') && ($_SESSION['position']=='1')){
//	define('DB_NAME', 'dbcontacttracing');
//}else if ($_SESSION['campus']<>'') {
	define('DB_NAME', 'cvsuc006_dbcontacttracing'.$_SESSION['campus'] );
//}


/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    //die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>


