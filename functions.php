<?php

//$password = md5("Smith");
//echo $password."<br><br>";
//$code = md5(uniqid(rand(), TRUE));
//echo $code;



//Generate a unique code
  function getUniqueCode($length = "") {
    $code = md5(uniqid(rand(), TRUE));
      if ($length != "") {
        return substr($code, 0, $length);
      } else {
        return $code;
      }
  }


//$plainText = getUniqueCode(15);
//echo $plainText;


function generateHash($plainText, $salt = NULL) {
  if ($salt === NULL) {
    $salt = substr(md5(uniqid(rand(), TRUE)), 0, 25);
  } else {
    $salt = substr($salt, 0, 25);
  }
  return $salt . sha1($salt . $plainText);
}


//echo $newpassword;
//$compare = generateHash($_POST['password'], $newpassword);
//echo $compare;

function createNewUser($username, $firstname, $lastname, $email, $password) {
  global $mysqli, $db_table_prefix;
  //Generate A random userid

  $character_array = array_merge(range(a, z), range(0, 9));
  $rand_string = "";
  for ($i = 0; $i < 6; $i++) {
    $rand_string .= $character_array[rand(
      0, (count($character_array) - 1)
    )];
  }
  //echo $rand_string;
  //echo $username;
  //echo $firstname;
  //echo $lastname;
  //echo $email;
  //echo $password;

  $newpassword = generateHash($password);

  //echo $newpassword;

  $stmt = $mysqli->prepare(
    "INSERT INTO " . $db_table_prefix . "UserDetails (
		UserID,
		UserName,
		FirstName,
		LastName,
		Email,
		Password,
		MemberSince,
		Active
		)
		VALUES (
		'" . $rand_string . "',
		?,
		?,
		?,
		?,
		?,
        '" . time() . "',
        1
		)"
  );
  $stmt->bind_param("sssss", $username, $firstname, $lastname, $email, $newpassword);
  //print_r($stmt);
  $result = $stmt->execute();
  //print_r($result);
  $stmt->close();
  return $result;

}

//Retrieve complete user information by username
function fetchUserDetails($username) {
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("SELECT
		UserID,
		UserName,
		FirstName,
		LastName,
		Email,
		Password,
		MemberSince,
		Active
		FROM ".$db_table_prefix."UserDetails
		WHERE
		UserName = ?
		LIMIT 1");
  $stmt->bind_param("s", $username);

  $stmt->execute();
  $stmt->bind_result($UserID, $UserName, $FirstName, $LastName, $Email, $Password, $MemberSince, $Active);
  while ($stmt->fetch()){
    $row = array('UserID' => $UserID,
      'UserName' => $UserName,
      'FirstName' => $FirstName,
      'LastName' => $LastName,
      'Email' => $Email,
      'Password' => $Password,
      'MemberSince' => $MemberSince,
      'Active' => $Active);
  }
  $stmt->close();
  return ($row);
}



//Check if a user is logged in
function isUserLoggedIn() {
  global $loggedInUser,$mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("SELECT
		UserID,
		Password
		FROM ".$db_table_prefix."UserDetails
		WHERE
		UserID = ?
		AND
		Password = ?
		AND
		active = 1
		LIMIT 1");
  $stmt->bind_param("ss", $loggedInUser->user_id, $loggedInUser->hash_pw);
  $stmt->execute();
  $stmt->store_result();
  $num_returns = $stmt->num_rows;
  $stmt->close();

  if($loggedInUser == NULL)
  {
    return false;
  }
  else
  {
    if ($num_returns > 0)
    {
      return true;
    }
    else
    {
      destroySession("ThisUser");
      return false;
    }
  }
}

//Check if a user is admin in
function isAdmin() {
	global $loggedInUser,$mysqli,$db_table_prefix;
	$isadmin = $loggedInUser->username;
	$stmt = $mysqli->prepare("SELECT
		UserID,
		Password
		FROM ".$db_table_prefix."UserDetails
		WHERE
		UserID = ?
		AND
		Password = ?
		AND
		active = 1
		AND roleAdmin = 1 
		LIMIT 1");
	$stmt->bind_param("is", $loggedInUser->user_id, $loggedInUser->hash_pw);
	$stmt->execute();
	$stmt->store_result();
	$isadmin = $stmt->num_rows;
	$stmt->close();
	/*ends here*/
	if($isadmin >0)
	{
		return true;
	}else
	{
		return false;
	}
}

//Check if a user is admin in
function isSuperUSer() {
	global $loggedInUser,$mysqli,$db_table_prefix;
	$isadmin = $loggedInUser->username;
	$stmt = $mysqli->prepare("SELECT
		UserID,
		Password
		FROM ".$db_table_prefix."UserDetails
		WHERE
		UserID = ?
		AND
		Password = ?
		AND
		active = 1
		AND roleSuperUser = 1 
		LIMIT 1");
	$stmt->bind_param("is", $loggedInUser->user_id, $loggedInUser->hash_pw);
	$stmt->execute();
	$stmt->store_result();
	$isadmin = $stmt->num_rows;
	$stmt->close();
	/*ends here*/
	if($isadmin >0)
	{
		return true;
	}else
	{
		return false;
	}
}



//Destroys a session as part of logout
function destroySession($name) {
  if(isset($_SESSION[$name]))
  {
    $_SESSION[$name] = NULL;
    unset($_SESSION[$name]);
  }
}


//Retrieve complete user information of all users
function fetchAllUsers() {

  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("SELECT
		UserID,
		UserName,
		FirstName,
		LastName,
		Email,
		Password,
		MemberSince,
		Active
		FROM ".$db_table_prefix."UserDetails
		");

  $stmt->execute();
  $stmt->bind_result($UserID, $UserName, $FirstName, $LastName, $Email, $Password, $MemberSince, $Active);
  while ($stmt->fetch()){
    $row[] = array('UserID' => $UserID,
      'UserName' => $UserName,
      'FirstName' => $FirstName,
      'LastName' => $LastName,
      'Email' => $Email,
      'Password' => $Password,
      'MemberSince' => $MemberSince,
      'Active' => $Active);
  }
  $stmt->close();
  return ($row);
}

//function to fetch all the blogs that are available. was not ordered - fix applied
function fetchAllBlogs() {
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("SELECT
		bloglisting.blogid,
		bloglisting.title,
	    bloglisting.datecreated,
	    bloglisting.deleteflag,
	    bloglisting.active,
	    whomadewho.userid,
	    blogcontent.blogcontent,
	    UserDetails.UserName,
	    UserDetails.FirstName,
	    UserDetails.LastName,
	    UserDetails.Email

        FROM whomadewho INNER JOIN bloglisting ON whomadewho.blogid = bloglisting.blogid
	 INNER JOIN UserDetails ON whomadewho.userid = UserDetails.UserID
	 INNER JOIN blogcontent ON blogcontent.blogid = bloglisting.blogid
   WHERE bloglisting.publish = 1
  
	 ORDER BY bloglisting.datecreated DESC
		");

  $stmt->execute();
  $stmt->bind_result($blogid, $title, $datecreated, $deleteflag, $active, $userid, $blogcontent, $username, $firstname, $lastname, $email);
  while ($stmt->fetch()){
    $row[] = array('blogid' => $blogid,
      'title' => $title,
      'datecreated' => $datecreated,
      'deleteflag' => $deleteflag,
      'active' => $active,
      'userid' => $userid,
      'blogcontent' => $blogcontent,
      'username' => $username,
      'firstname' => $firstname,
      'lastname' => $lastname,
      'email'  => $email
    );
  }
  $stmt->close();
  return ($row);
}



// only fetch the blogs that the logged in user has created. Notice that we have used $loggedInUser
function fetchMyBlogs() {
  global $loggedInUser, $mysqli,$db_table_prefix;
//	$row=0;
  $stmt = $mysqli->prepare("SELECT
		bloglisting.blogid,
		bloglisting.title,
	    bloglisting.datecreated,
	    bloglisting.deleteflag,
	    bloglisting.active,
	    whomadewho.userid,
	    blogcontent.blogcontent,
	    bloglisting.publish
	    FROM whomadewho INNER JOIN bloglisting ON whomadewho.blogid = bloglisting.blogid
	                    INNER JOIN blogcontent ON blogcontent.blogid = bloglisting.blogid
		WHERE whomadewho.userid = ?
		ORDER BY bloglisting.datecreated DESC");
  $stmt->bind_param("s", $loggedInUser->user_id);
  $stmt->execute();
  $stmt->bind_result($blogid, $title, $datecreated, $deleteflag, $active, $userid, $blogcontent,$publish);
  while ($stmt->fetch()){
    $row[] = array('blogid'       => $blogid,
      'title'        => $title,
      'datecreated'  => $datecreated,
      'deleteflag'   => $deleteflag,
      'active'       => $active,
      'userid'       => $userid,
      'blogcontent'  => $blogcontent,
	    'publish'      => $publish
    );
  }
  $stmt->close();
  return ($row);
}




// fetch a particular blog with blog id.
function fetchThisBlog($blogid) {
  global $loggedInUser, $mysqli,$db_table_prefix;
	$row=0;
  $stmt = $mysqli->prepare("SELECT
		bloglisting.blogid,
		bloglisting.title,
	    bloglisting.datecreated,
	    bloglisting.deleteflag,
	    bloglisting.active,
	    whomadewho.userid,
	    blogcontent.blogcontent,
	    UserDetails.UserName,
	    UserDetails.FirstName,
	    UserDetails.LastName,
	    UserDetails.Email

        FROM whomadewho INNER JOIN bloglisting ON whomadewho.blogid = bloglisting.blogid
	 INNER JOIN UserDetails ON whomadewho.userid = UserDetails.UserID
	 INNER JOIN blogcontent ON blogcontent.blogid = bloglisting.blogid
		WHERE bloglisting.blogid = ?");
  $stmt->bind_param("s", $blogid);
  $stmt->execute();
  $stmt->bind_result($blogid, $title, $datecreated, $deleteflag, $active, $userid, $blogcontent, $username, $firstname, $lastname, $email);
  while ($stmt->fetch()){
    $row = array('blogid'       => $blogid,
      'title'        => $title,
      'datecreated'  => $datecreated,
      'deleteflag'   => $deleteflag,
      'active'       => $active,
      'userid'       => $userid,
      'blogcontent'  => $blogcontent,
      'username' => $username,
      'firstname' => $firstname,
      'lastname' => $lastname,
      'email'  => $email
    );
  }
  $stmt->close();
  return ($row);
}




//create a blog, notice the similarity with create user.
function createBlog($title, $blog){
  global $loggedInUser, $mysqli,$db_table_prefix;


  $character_array = array_merge(range(a, z), range(0, 9));
  $rand_string = "";
  for ($i = 0; $i < 6; $i++) {
    $rand_string .= $character_array[rand(
      0, (count($character_array) - 1)
    )];
  }
  $inserted_blogid = $rand_string;

  $stmt = $mysqli->prepare(
    "INSERT INTO bloglisting (
		blogid,
		title,
		datecreated,
		deleteflag,
		active
		)
		VALUES (
		?,
		?,
		'" . time() . "',
		0,
		1
		)"
  );
  $stmt->bind_param("ss",$inserted_blogid,$title);
  $result = $stmt->execute();
  $stmt->close();
  //return $result;

  $stmt = $mysqli->prepare(
    "INSERT INTO blogcontent (
		blogid,
		blogcontent
		)
		VALUES (
		?,
		?
		)"
  );
  $stmt->bind_param("ss",$inserted_blogid, $blog);
  $result = $stmt->execute();
  $stmt->close();
  //return $result;


  $stmt = $mysqli->prepare(
    "INSERT INTO whomadewho (
		blogid,
		userid
		)
		VALUES (
        ?,
        ?
		)"
  );
  $stmt->bind_param("ss",$inserted_blogid, $loggedInUser->user_id);
  $result = $stmt->execute();
  $stmt->close();
  return $result;

}


//truncate characters on the front page for description.
function truncate_chars($text, $limit, $ellipsis = '...') {
  if( strlen($text) > $limit )
    $text = trim(substr($text, 0, $limit)) . $ellipsis;
  return $text;
}

// only fetch the users
function fetchActiveUsers($offset,$left_rec) {
	global $loggedInUser, $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT
		UserID,
		UserName,
		FirstName,
		LastName,
		Email,
		Password,
		MemberSince,
		Active,
		roleAdmin,
		roleSuperUser,
		delUser
		FROM ".$db_table_prefix."UserDetails
		where active =1
		LIMIT ".$offset.",".$left_rec);
	$stmt->execute();
	$stmt->bind_result($UserID, $UserName, $FirstName, $LastName, $Email, $Password, $MemberSince, $Active,$roleAdmin,$roleSuperUser,$delUser);
	while ($stmt->fetch()){
		$row[] = array('UserID' => $UserID,
			'UserName' => $UserName,
			'FirstName' => $FirstName,
			'LastName' => $LastName,
			'Email' => $Email,
			'Password' => $Password,
			'MemberSince' => $MemberSince,
			'Active' => $Active,
			'roleAdmin'=>$roleAdmin,
			'roleSuperUser'=>$roleSuperUser,
			'delUser'=>$delUser);
	}
	$stmt->close();
	return ($row);
}

function fetchActiveUSersCount() {
	global $loggedInUser, $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT
		UserID,
		UserName,
		FirstName,
		LastName,
		Email,
		Password,
		MemberSince,
		Active
		FROM ".$db_table_prefix."UserDetails
		where active =1
		order by UserName ");
	
	$stmt->execute();
	$stmt->bind_result($UserID, $UserName, $FirstName, $LastName, $Email, $Password, $MemberSince, $Active);
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	return ($num_returns);
}
function fakedeleteAdmin($userid)
{
	global $mysqli, $db_table_prefix;
	$stmt = $mysqli->prepare(
		"UPDATE " . $db_table_prefix . "UserDetails
		SET
		roleAdmin=1
		WHERE
		UserID = ?
		LIMIT 1"
	);
	$stmt->bind_param("s", $userid);
	$result = $stmt->execute();
	$stmt->close();
	
	return $result;
}
function fakedeleteUser($userid)
{
	global $mysqli, $db_table_prefix;
	$stmt = $mysqli->prepare(
		"UPDATE " . $db_table_prefix . "UserDetails
		SET
		delUser=1
		WHERE
		UserID = ?
		LIMIT 1"
	);
	$stmt->bind_param("s", $userid);
	$result = $stmt->execute();
	$stmt->close();
	
	return $result;
}
function fakedeleteSuperUser($userid)
{
	global $mysqli, $db_table_prefix;
	$stmt = $mysqli->prepare(
		"UPDATE " . $db_table_prefix . "UserDetails
		SET
		roleSuperUser=1
		WHERE
		UserID = ?
		LIMIT 1"
	);
	$stmt->bind_param("s", $userid);
	$result = $stmt->execute();
	$stmt->close();
	
	return $result;
}
//Revoke access

function revokedeleteAdmin($userid)
{
	global $mysqli, $db_table_prefix;
	$stmt = $mysqli->prepare(
		"UPDATE " . $db_table_prefix . "UserDetails
		SET
		roleAdmin=0
		WHERE
		UserID = ?
		LIMIT 1"
	);
	$stmt->bind_param("s", $userid);
	$result = $stmt->execute();
	$stmt->close();
	
	return $result;
}
function revokedeleteUser($userid)
{
	global $mysqli, $db_table_prefix;
	$stmt = $mysqli->prepare(
		"UPDATE " . $db_table_prefix . "UserDetails
		SET
		delUser=0
		WHERE
		UserID = ?
		LIMIT 1"
	);
	$stmt->bind_param("s", $userid);
	$result = $stmt->execute();
	$stmt->close();
	
	return $result;
}
function revokedeleteSuperUser($userid)
{
	global $mysqli, $db_table_prefix;
	$stmt = $mysqli->prepare(
		"UPDATE " . $db_table_prefix . "UserDetails
		SET
		roleSuperUser=0
		WHERE
		UserID = ?
		LIMIT 1"
	);
	$stmt->bind_param("s", $userid);
	$result = $stmt->execute();
	$stmt->close();
	
	return $result;
}
function publishBlog($blogid)
{
	global $mysqli, $db_table_prefix;
	$stmt = $mysqli->prepare(
		"UPDATE " . $db_table_prefix . "bloglisting
		SET
		publish=1
		WHERE
		blogid = ?
		LIMIT 1"
	);
	$stmt->bind_param("s", $blogid);
	$result = $stmt->execute();
	$stmt->close();
	
	return $result;
}
//function to fetch all the blogs that are available. was not ordered - fix applied
function fetchAllBlogsToPublish($start_from,$num_rec_per_page) {
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT
		bloglisting.blogid,
		bloglisting.title,
	    bloglisting.datecreated,
	    bloglisting.deleteflag,
	    bloglisting.active,
	    bloglisting.publish
	 FROM bloglisting
	 ORDER BY bloglisting.datecreated DESC
	LIMIT	".$start_from.",".$num_rec_per_page);
	
	$stmt->execute();
	$stmt->bind_result($blogid, $title, $datecreated, $deleteflag, $active,$publish);
	while ($stmt->fetch()){
		$row[] = array('blogid' => $blogid,
			'title' => $title,
			'datecreated' => $datecreated,
			'deleteflag' => $deleteflag,
			'active' => $active,
			'publish' => $publish
			
		);
	}
	$stmt->close();
	return ($row);
}
/*manage bolgs*/

function allowBlogpublish($blogid)
{
	global $mysqli, $db_table_prefix;
	$stmt = $mysqli->prepare(
		"UPDATE " . $db_table_prefix . "bloglisting
		SET
		publish=1
		WHERE
		blogid = ?
		LIMIT 1"
	);
	$stmt->bind_param("s", $blogid);
	$result = $stmt->execute();
	$stmt->close();
	
	return $result;
}

function revokeBlogpublish($blogid)
{
	global $mysqli, $db_table_prefix;
	$stmt = $mysqli->prepare(
		"UPDATE " . $db_table_prefix . "bloglisting
		SET
		publish=0
		WHERE
		blogid = ?
		LIMIT 1"
	);
	$stmt->bind_param("s", $blogid);
	$result = $stmt->execute();
	$stmt->close();
	
	return $result;
}
function deleteBlog($blogid)
{
	global $mysqli, $db_table_prefix;
	$stmt = $mysqli->prepare(
		"UPDATE " . $db_table_prefix . "bloglisting
		SET
		deleteflag=1
		WHERE
		blogid = ?
		LIMIT 1"
	);
	$stmt->bind_param("s", $blogid);
	$result = $stmt->execute();
	$stmt->close();
	
	return $result;
}

function addDeletedBlog($blogid)
{
	global $mysqli, $db_table_prefix;
	$stmt = $mysqli->prepare(
		"UPDATE " . $db_table_prefix . "bloglisting
		SET
		deleteflag=0
		WHERE
		blogid = ?
		LIMIT 1"
	);
	$stmt->bind_param("s", $blogid);
	$result = $stmt->execute();
	$stmt->close();
	
	return $result;
}

function fetchBlogCount() {
	global $loggedInUser, $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT
		bloglisting.blogid,
		bloglisting.title,
	    bloglisting.datecreated,
	    bloglisting.deleteflag,
	    bloglisting.active,
	    bloglisting.publish
	 FROM bloglisting");
	
	$stmt->execute();
	//$stmt->bind_result($UserID, $UserName, $FirstName, $LastName, $Email, $Password, $MemberSince, $Active);
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	return ($num_returns);
}