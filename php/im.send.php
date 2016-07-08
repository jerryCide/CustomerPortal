<?php
include("vars.php");
@session_start();
echo "called";
if(empty($_SESSION['USER']) && empty($_REQUEST['recvr']) && empty($_REQUEST['msg']))
{
	die("Failed!");	
}


$username = getCurrentUsername();
$userFullName = getUserFullName($username);

$recvr = $_REQUEST['recvr'];
$msg = addslashes($_REQUEST['msg']);

open_db();
if(!mysqli_query($db,"INSERT INTO im_tab(sender,recvr,isread,msg) VALUES('$username','$recvr',0,'$msg')"))
{
	?>
    <input type="hidden" value="0" id="isError">
    <?php	
}
else
{
	addNotification("New IM Message","<b>$userFullName</b> has sent you a IM message on <b>$main_title:</b><br>$msg<br><a href=\"$co_main_url\">Login to reply</a>",0,$recvr,0,1,"",NULL);
	?>
    <input type="hidden" value="1" id="isError">
    <?php	
}

close_db();
?>