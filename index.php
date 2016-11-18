<html>
<head>
	
	<script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: en_US</script><br>
</head>
</html>

<?php
	require_once("config.php");
	require_once("header.php");

	//Prevent the user visiting the logged in page if he/she is already logged in
	if(isUserLoggedIn()) {
		header("Location: myaccount.php");
		die();
	}

	// call to fetchallblogs function from functions.php
	$allblogs = fetchAllBlogs();

	echo "
			<div id='content-wrap'>
  			<div id='content'>
    			<div id='main'>";
            
							foreach($allblogs as $bloginfo) {
								$summary = truncate_chars($bloginfo['blogcontent'], 150, '...');
								//$summary  = $bloginfo['blogcontent'];
								$publisheddate = date("M d, Y", $bloginfo['datecreated']);

								echo "

										<a name='TemplateInfo' href='viewblog.php?blogid=" . $bloginfo['blogid'] . "'><h1>" . $bloginfo['title'] . "</h1></a>
										<br>
										<p>" . $summary . "</p>
										
										<p class='align-right'>
										
										<iframe src=\"https://www.facebook.com/plugins/share_button.php?href=https%3A%2F%2Fharshadablog.herokuapp.com%2Fviewblog.php%3Fblogid%3D".$bloginfo['blogid']."&layout=button_count&mobile_iframe=true&width=79&height=20&appId\" width=\"87\" height=\"20\" style=\"border:none;overflow:hidden\" scrolling=\"no\" frameborder=\"0\" allowTransparency=\"true\"></iframe>
										&nbsp;&nbsp;<script type=IN/Share data-url=https://harshadablog.herokuapp.com/viewblog.php?blogid=".$bloginfo['blogid']." data-counter=right></script>
										</p>
										<p class='post-footer align-right'>
										
										BY : " . $bloginfo['firstname'] . " " . $bloginfo['lastname'] .  "
												 $publisheddate
										<a href='viewblog.php?blogid=" . $bloginfo['blogid'] . "'>Read more</a>
										
										</p>
										<br><br>
										";
							}
							echo "
					</div>




	";

require_once("footer.php");

