<?php
/**
 * Created by PhpStorm.
 * User: hghar
 * Date: 11/11/2016
 * Time: 8:18 PM
 */
 require_once("config.php");
/*$rec_limit = 5;*/
$num_rec_per_page=5;
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
$start_from = ($page-1) * $num_rec_per_page;

//$row = mysqli_fetch_array($countUSer);
$activeUser = fetchActiveUsers($start_from,$num_rec_per_page);
	require_once("header.php");

	echo "
		<div id='content-wrap'>
			<div id='content'>
				<div id='main'>";
				    foreach($activeUser as $displayUser)
				    {
					    echo '<h1>'. $displayUser['UserName'] .'</h1>';
					    echo '<h4>'. $displayUser['FirstName'] .' '. $displayUser['LastName'] .'</h4>';
					    echo '<h2>'. $displayUser['Email'] .'</h2>';
					    echo '<h2>'. date("M d, Y",$displayUser['MemberSince']) .'</h2>';
					    if($displayUser['roleAdmin']==0)
					    echo '<a class="admin" href="processManage.php?flag=admin&UserID='.$displayUser['UserID'].'">Admin</a>';
					    else
						    echo '<a class="admindisable" href="processRevoke.php?flag=admin&UserID='.$displayUser['UserID'].'">Admin</a>';
					    if($displayUser['delUser']==0)
					    echo '<a class="admin" href="processManage.php?flag=delete&UserID='.$displayUser['UserID'].'">DeActivate</a>';
					    else
						    echo '<a class="admindisable" href="processRevoke.php?flag=delete&UserID='.$displayUser['UserID'].'">Activate</a>';
					    if($displayUser['roleSuperUser']==0)
					    echo '<a class="admin" href="processManage.php?flag=superUser&UserID='.$displayUser['UserID'].'">Super User</a><br><br>';
					    else
						    echo '<a class="admindisable" href="processRevoke.php?flag=superUser&UserID='.$displayUser['UserID'].'">Super User</a><br><br>';
					  
				    }
$total_records =fetchActiveUSersCount();
$total_pages = ceil($total_records / $num_rec_per_page);
echo "<a href='manageUser.php?page=1'>".'|<'."</a> "; // Goto 1st page
for ($i=1; $i<=$total_pages; $i++) {
	echo "<a href='manageUser.php?page=".$i."'>".$i."</a> ";
};
echo "<a href='manageUser.php?page=$total_pages'>".'>|'."</a> "; // Goto last page

?>
	</div>



<?php require_once("footer.php"); ?>