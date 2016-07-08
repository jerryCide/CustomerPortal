<?php
include("vars.php");
open_db();
session_start();
if(empty($_REQUEST['article_id']))
{
	die("No Article ID Supplied");
}

if(empty($_SESSION['USER']))
{
	die("You are not logged in");
}
else
{
	$session_var = unserialize($_SESSION['USER']);
	$username = $session_var->username;
}

$article_id = $_REQUEST['article_id'];
$comment = $_REQUEST['comment'];


if(!mysqli_query($db,"INSERT INTO press_comment_tab(author,comment,date_posted,article_id) VALUES('$username','$comment','$today',$article_id)"))
{
	?>
	<input type="hidden" id="isError" value="1">
	<?php
}
else
{
	?>
	<input type="hidden" id="isError" value="0">
    <input type="hidden" id="date_added" value="<?=date("F d, Y",strtotime($today))?>">
    <input type="hidden" id="author" value="<?=$username?>">
	<?php
}
close_db();
?>