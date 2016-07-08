<?php
/*if(empty($_REQUEST['username']))
{
	die("No Username Sent");
}
else
{
	$username = $_REQUEST['username'];
}*/

include("vars.php");

session_start();
$session_user = unserialize($_SESSION['USER']);
$username = $session_user->username;


open_db();

$res = mysqli_query($db,"SELECT * FROM mail_tab where (owner = '$username' OR owner = '*') and isread = 0 order by date_sent DESC");

close_db();

if(empty($_SESSION['mailCount']))
{
	$_SESSION['mailCount'] = mysqli_num_rows($res);
}


if($_SESSION['mailCount'] != mysqli_num_rows($res))
{
	?>
	<input type="hidden" value="1" id="doAlert">
	<?php	
}
else
{
	?>
	<input type="hidden" value="0" id="doAlert">
	<?php	
	
}

?>
<input type="hidden" value="<?=(mysqli_num_rows($res) > 0)?1:0?>" id="isNewMail">


