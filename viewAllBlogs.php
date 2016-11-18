<?php
/**
 * Created by PhpStorm.
 * User: hghar
 * Date: 11/16/2016
 * Time: 11:37 PM
 */
	require_once("config.php");
	$myblogs = fetchAllBlogs();
		print_r('inside viewmy blogs php'.$myblogs);

	require_once("header.php");

	echo "
		<div id='content-wrap'>
			<div id='content'>
				<div id='main'>

   				<table>
				    <tr>
				        <th>BlogID</th>
				        <th>Title</th>
				        <th>View</th>
				        <th>Publish</th>
				        <th>Delete</th>
				    </tr>";
            if($myblogs >0)
	            foreach($myblogs as $displayblog)
	            {
		            echo '<tr>';
		            echo '<td>'. $displayblog['blogid'] .'</td>';
		            echo '<td>'. $displayblog['title'] .'</td>';
		            echo '<td><a href="viewblog.php?blogid='.$displayblog['blogid'].'">View</a></td>';
		            echo '<td align="center"><a href="publish.php?blogid='.$displayblog['blogid'].'">'.$displayblog['active'].'</a></td>';
		            
		            echo '<td><a href="deleteblog.php?blogid='.$displayblog['blogid'].'">Delete</a></td>';
		            echo '</tr>';
	            }
?>
	</table>
	</div>


<?php require_once("footer.php"); ?>