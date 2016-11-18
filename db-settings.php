<?php

//Development Database Information
$db_host = "sql9.freemysqlhosting.net"; //Host address (most likely localhost)
$db_name = "sql9145020"; //Name of Database
$db_user = "sql9145020"; //Name of database user
$db_pass = "iGdr79ghRu"; //Password for database user
$db_table_prefix = ""; // if the table prefix exists use this variable as a global


//following variable declaration
GLOBAL $errors;
GLOBAL $successes;

$errors = array();
$successes = array();

/* Create a new mysqli object with database connection parameters */

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
GLOBAL $mysqli;

if(mysqli_connect_errno()) {
	//display the reason for mysql connection error.
	echo "Connection Failed: " . mysqli_connect_errno();
	exit();
}else{
	//echo "Connection Successful";
}
?>