<?php


require_once("config.php");

require_once("header.php");

echo "
<div id='content-wrap'>
  <div id='content'>
    <div id='main'>

		<p>Hey, $loggedInUser->first_name $loggedInUser->last_name.</p>

		<p>Welcome , Post you creative ideas.</p>
		<p>Just so you know, you registered this account on " . date("M d, Y", $loggedInUser->member_since) . "</p>.";

?>
		</div>


<?php require_once("footer.php"); ?>