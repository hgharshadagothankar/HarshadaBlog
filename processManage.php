<?php
/**
 * Created by PhpStorm.
 * User: hghar
 * Date: 11/16/2016
 * Time: 6:41 PM
 */
require_once("config.php");
$action=$_GET['flag'];
$userID=$_GET['UserID'];


print("process".$action);
if($action =='admin')
	$result=fakedeleteAdmin($userID);
if($action =='delete')
	$result=fakedeleteUser($userID);
if($action =='superUser')
	$result=fakedeleteSuperUser($userID);

print("inside process".$result);
header("Location: manageUser.php?page=0");
?>