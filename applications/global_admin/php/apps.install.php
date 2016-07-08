<?php
include("../../../php/vars.php");
open_db();
if(empty($_REQUEST['app_dir']))
{
	die("No App Directory");
}

$app_dir = $_REQUEST['app_dir'];

if(!mysqli_query($db,"INSERT INTO app_tab(app_name,app_dir,app_isonline) VALUES('[Unnamed]','$app_dir',0)"))
{
	echo "Install Failed";	
}
else
{
	echo "Installed Successfully, Please name application before putting online";
}


close_db();
?>