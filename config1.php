<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */

if(!isset($_SESSION)){ session_start();}
define('DB_SERVER1', 'localhost');
define('DB_USERNAME1', 'root');
define('DB_PASSWORD1', '');


//if (($_SESSION['campus']=='9') && ($_SESSION['position']=='1')){
//	define('DB_NAME', 'dbcontacttracing');
//}else if ($_SESSION['campus']<>'') {
	define('DB_NAME1', 'cvsuc006_dbcontacttracing9');
//}


/* Attempt to connect to MySQL database */
$link1 = mysqli_connect(DB_SERVER1, DB_USERNAME1, DB_PASSWORD1, DB_NAME1);
 
// Check connection
if($link1 === false){
    //die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>


