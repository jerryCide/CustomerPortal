<?php
if(empty($_REQUEST['app_id']))
{
	die("No Application ID Found");
}
$app_id = $_REQUEST['app_id'];

include("../../../php/vars.php");
open_db();
if(mysqli_query($db,"DELETE FROM app_tab WHERE app_id = $app_id"))
{
	if(mysqli_query($db,"DELETE FROM app_permission_tab WHERE app_id = $app_id"))
	{
		echo "Successfully Uninstalled";	
	}
}
else
{
	echo "Error Uninstalling Application";	
}
close_db();

?>