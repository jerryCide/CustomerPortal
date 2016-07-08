<?php
if(!empty($_REQUEST['blog_id']))
{
	$blod_id = $_REQUEST['blog_id'];
	include("vars.php");
 	open_db();
 	mysqli_query($db,"DELETE FROM blog_tab WHERE blog_id = $blod_id");
	mysqli_query($db,"DELETE FROM blog_comment_tab WHERE blog_id = $blod_id");
 	close_db();
}

?>