<?php

	require_once("config.php");
	$myblogs = fetchMyBlogs();

	require_once("header.php");

	echo "
		<div id='content-wrap'>
			<div id='content'>
				<div id='main'>

   				<table cellspacing='10%'>
				    <tr>
				        <th>BlogID</th>
				        <th>Title</th>
				        <th>View</th>
				        <th>Publish Status</th>
				        <th>Delete</th>
				    </tr>";
            if($myblogs >0)
				    foreach($myblogs as $displayblog)
				    {
				      echo '<tr>';
				      echo '<td>'. $displayblog['blogid'] .'</td>';
				      echo '<td>'. $displayblog['title'] .'</td>';
				      echo '<td><a class="admin" href="viewblog.php?blogid='.$displayblog['blogid'].'">View</a></td>';
					    
					    if($displayblog['publish']==0)
				      echo '<td align="center"><h2>Pending</h2></td>';
					    else
						    echo '<td align="center"><h2>Approved</h2></td>';
					
					    if($displayblog['deleteflag']==1)
				      echo '<td><h2>Yes</h2></td>';
					    else
						    echo '<td><h2>No</h2></td>';
				      echo '</tr>';
				    }
?>
					</table>
				</div>


<?php require_once("footer.php"); ?>