<?php

	//error reporting and warning display.
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');

	if (!ini_get('date.timezone')) {
		date_default_timezone_set('GMT');
	}

	require_once("db-settings.php"); //Require DB connection
	require_once("functions.php"); // database and other functions are written in this file
	require_once("class.user.php"); // Import the class logged in user so that we have it handy.

	session_start();

	//loggedInUser can be used globally if constructed
	if(isset($_SESSION["ThisUser"]) && is_object($_SESSION["ThisUser"]))
	{
		$loggedInUser = $_SESSION["ThisUser"];
	}

?>

<pre>
	<?php
		//print_r($_SESSION);
		//print_r($loggedInUser);
	?>
</pre>


