<?php
/**
 * Created by PhpStorm.
 * User: hghar
 * Date: 11/16/2016
 * Time: 11:56 PM
 */

	require_once("config.php");

 $num_rec_per_page=5;
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
$start_from = ($page-1) * $num_rec_per_page;
$myblogs = fetchAllBlogsToPublish($start_from,$num_rec_per_page);
	require_once("header.php");

	echo "
		<div id='content-wrap'>
			<div id='content'>
				<div id='main'>";
            if($myblogs >0)
	            foreach($myblogs as $displayblog)
	            {
		            echo '<h1>Blog ID:'. $displayblog['blogid'] .'</h1>';
		            echo '<h2>Blog Title: '. $displayblog['title'] .'</h2>';
		            echo '<h2>Created On: '. date("M d, Y",$displayblog['datecreated']) .'</h2>';
		            echo '<a class="admin" href="viewblog.php?blogid='.$displayblog['blogid'].'">View</a>';
		            if($displayblog['publish']==0)
		            echo '<a class=admin href="processPublish.php?flag=publish&blogid='.$displayblog['blogid'].'">Publish</a>';
		            else
			            echo '<a class="admindisable" href="processPublish.php?flag=Unpublish&blogid='.$displayblog['blogid'].'">UnPublish</a>';
		            if($displayblog['deleteflag']==0)
		            echo '<a class="admin" href="processPublish.php?flag=delete&blogid='.$displayblog['blogid'].'">Delete</a>';
		            else
			            echo '<a class="admindisable" href="processPublish.php?flag=add&blogid='.$displayblog['blogid'].'">Add</a>';
		              echo '<h2></h2><br>';
		         
	            }
?>
<br>

<?php
  $total_records=fetchBlogCount();
	$total_pages = ceil($total_records / $num_rec_per_page);
	
	echo "<a href='publish.php?page=1'>".'|<'."</a> "; // Goto 1st page
	
	for ($i=1; $i<=$total_pages; $i++) {
	echo "<a href='publish.php?page=".$i."'>".$i."</a> ";
	};
	echo "<a href='publish.php?page=$total_pages'>".'>|'."</a> "; // Goto last page
?>
	</div>


<?php require_once("footer.php"); ?>