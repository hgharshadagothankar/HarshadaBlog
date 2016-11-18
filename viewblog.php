<html>
<head>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.8.0/styles/default.min.css">
</head>

</html>
<?php


require_once("config.php");
require_once("header.php");

$thisblogid = $_GET['blogid'];
$thisblog = fetchThisBlog($thisblogid);

?>
<div id='content-wrap'>
	<div id='content'>
		<div id='main'>
		<?php
			echo "<h1>"; print $thisblog['title']; echo "</h1>";
		  echo "<pre><code class=javascript>"; print $thisblog['blogcontent']; echo "</code></pre>";
		echo "<a  href='viewmyblogs.php'><div class='admin'>Back</div></a>";
		?>
	</div>

<?php require_once("footer.php"); ?>
