<?php
/**
 * Created by PhpStorm.
 * User: hghar
 * Date: 11/17/2016
 * Time: 11:27 AM
 */

require_once("config.php");
$action=$_GET['flag'];
$blogID=$_GET['blogid'];


print("process".$action);
if($action =='publish')
	$result=allowBlogpublish($blogID);
if($action =='Unpublish')
	$result=revokeBlogpublish($blogID);
if($action =='delete')
	$result=deleteBlog($blogID);
if($action =='add')
	$result=addDeletedBlog($blogID);
header("Location: publish.php");