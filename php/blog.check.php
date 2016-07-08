<?php
include("vars.php");
@session_start();

$last_refresh_date = $_REQUEST['last_refresh'];

open_db();
$res = mysqli_query($db,"SELECT * FROM blog_tab WHERE blog_update_date > '$last_refresh_date'");

close_db();

$blog_id_list = "";
while($row = mysqli_fetch_array($res))
{
	$blog_id_list .= $row['blog_id'].",";	
}
$blog_id_list = rtrim($blog_id_list,',');
?>
<input type="hidden" value="<?=$blog_id_list?>" id="blog_id_list">
<input type="hidden" value="<?=mysqli_num_rows($res)>0?1:0?>" id="doGetBlogs">
<input type="hidden" value="<?=$today?>" id="last_refresh_new">

