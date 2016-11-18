
<html>
<head>
	
	
</head>
</html>
<?php

//Links for logged in user
if(isUserLoggedIn()) {
	echo "
	<ul>
		<li><a href='myaccount.php'>Account Home</a></li>";
if(isAdmin()) {
	echo "<li>
		<span class=\"dropdown\">
	<span class=\"dropbtn\">View Blog</span>
	<span class=\"dropdown-content\">
		<a href=viewmyblogs.php>My Blogs</a>
		<a href=publish.php?page=1>Manage All Blogs</a>
		<a href=\"#\">Link 3</a>
	</span>
</span>
		</li>";
}else{
		echo "<li><a href='viewmyblogs.php'>View My Blogs</a></li>";
	}
	echo "<li><a href='createblog.php'>Create A New Blog</a></li>";
if(isAdmin()) {
	echo "<li><a href='manageUser.php?page=1'>Manage Accounts</a></li>";
}
	echo	"<li><a href='logout.php'>Logout</a></li>
	</ul>";

}
//Links for users not logged in
else {
	echo "
	<ul>
			<li><a href='index.php'>Home</a></li>
			<li><a href='login.php'>Login</a></li>
			<li><a href='register.php'>Register</a></li>

	</ul>";
}

?>


