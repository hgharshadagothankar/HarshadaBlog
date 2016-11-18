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

