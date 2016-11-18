<html>
<head>
	
	<script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: en_US</script><br>
</head>
</html>

<?php


require_once("config.php");

require_once("header.php");
$num_rec_per_page=5;
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
$start_from = ($page-1) * $num_rec_per_page;
$allblogs = fetchAllBlogs($start_from,$num_rec_per_page);
// call to fetchallblogs function from functions.php



echo "
<div id='content-wrap'>
  <div id='content'>
    <div id='main'>

		<h1>Hey, $loggedInUser->first_name $loggedInUser->last_name.</h1>
		<h2>Just so you know, you registered this account on " . date("M d, Y", $loggedInUser->member_since) . "</h2>";
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

$total_records=fetchBlogCount();
$total_pages = ceil($total_records / $num_rec_per_page);

echo "<a href='index.php?page=1'>".'|<'."</a> "; // Goto 1st page

for ($i=1; $i<=$total_pages; $i++) {
	echo "<a href='index.php?page=".$i."'>".$i."</a> ";
};
echo "<a href='index.php?page=$total_pages'>".'>|'."</a> "; // Goto last page


?>
		</div>

<?php require_once("footer.php"); ?>