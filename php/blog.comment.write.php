<?php

include("vars.php");

@session_start();


if(!$owner = getCurrentUsername())
{
	die("Error: Not authourized to add comments here");
}

$owner_email = getUserEmail($owner);

open_db();

if(empty($_REQUEST['blog_id']))
{
	die("Error: No Blog ID");
}

$blog_id = $_REQUEST['blog_id'];
$comment = $_REQUEST['comment'];


if(!mysqli_query($db,"INSERT INTO blog_comment_tab(blog_id,owner,comment_date,comment) VALUES($blog_id,'$owner','$today','$comment')"))
{
	echo "Error: Cannot Add Comment ".mysql_error();
	?>
    <input type="hidden" value="1" id="isError" />
    <?php
}
else
{
	mysqli_query($db,"UPDATE blog_tab SET blog_update_date = '$today' WHERE blog_id = $blog_id");
	?>
    <input type="hidden" value="0" id="isError" />
    <input type="hidden" value="<?=$owner_email?>" id="owner_email">
    <?php	
	
	$contrib_res = mysqli_query($db,"SELECT `owner` FROM blog_comment WHERE blog_id = $blog_id GROUP BY `owner`");
	while($contrib_row = mysqli_fetch_array($contrib_res))
	{
		$owner_email .= getUserEmail($contrib_row['owner']).",";	
	}
	
	$owner_email = trim($owner_email,",");
	
	$notice = addslashes("Comment posted by <b>".getUserFullName(getCurrentUsername())."</b> To ".$main_title." Blog <a href=\"http://intranet/#blog_".$blog_id."\">Click Here</a> to view Blogs <br><br><b>Comment:</b> <br>".addslashes($comment));
	

	if(!addNotification("New Comment Posted to Blog",$notice,11,"",0,1,$owner_email,NULL))
	{
		echo "<p>Notification Failed</p>";	
	}
}

close_db();
?>