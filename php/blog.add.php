<?php
include("vars.php");
session_start();

if(!getCurrentUsername())
{
	die('You Are Not Logged In');
}

if(empty($_REQUEST['blog']) || !isset($_SESSION['USER']))
{
	die('No Blog or User Not Logged In');
}


$session_user = unserialize($_SESSION['USER']);
$username = $session_user->username;

$allowed_tags = "<b><u><br><a>";

$blog = strip_tags($_REQUEST['blog'],$allowed_tags);
$blog = addslashes($blog);

$blog_recv = $_REQUEST['blog_recv'];

open_db();
if(!mysqli_query($db,"INSERT INTO blog_tab(blog_sender,blog,blog_date,blog_recv) VALUES('$username','$blog','$today','$blog_recv')"))
{
	echo "Could Not Add Blog at this time, Try again later or call administrator";
}
close_db();



?>