<?php


@session_start();



$page = $_SESSION['disp_page'];
$session_user = unserialize($_SESSION['USER']);

if(empty($_REQUEST['username']))
{
	$username = "-";
}
else
{
	$username = $_REQUEST['username'];
}

//date_default_timezone_set('Jamaica');
include("vars.php");

$ip = $_SERVER['REMOTE_ADDR'];

open_db();

$res = mysqli_query($db,"SELECT * FROM session_tab WHERE ip = '$ip' AND username = '$username'");
$row = mysqli_fetch_array($res,MYSQL_ASSOC);
$logon_time = $today;
$session_expire = date("Y-m-d G:i:s",mktime(date("G"),date("i"),date("s")+30,date("m"),date("d"),date("Y")));

if($row['terminate'] == 1)
{
	?>
<input type="hidden" id="terminate" value="<?=$row['terminate']?>" />
<?php
	unset($_SESSION['USER']);
	echo "Session KILL Done. $today";
	die();		
}

if(mysqli_num_rows($res) == 0)
{
	if(!mysqli_query($db,"INSERT INTO session_tab(username,logon_time,session_expire,ip,page) VALUES('$username','$logon_time','$session_expire','$ip','$page')"))
	{
		echo "error inserting session";
	}
}
else
{
	if(!mysqli_query($db,"UPDATE session_tab SET session_expire = '$session_expire',page = '$page' WHERE ip = '$ip' and username = '$username'"))
	{
		echo "error updating session";
	}
}
mysqli_query($db,"DELETE FROM session_tab WHERE session_expire < '$today'"); //clean up all old session records
close_db();


$_SESSION['USER'] = $_SESSION['USER'];

?>