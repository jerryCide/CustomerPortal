<?php
$app_id = $_REQUEST['app_id'];

if(!mysqli_query($db,"DELETE FROM app_tab as at, app_permission_tab as apt WHERE at.app_id = $app_id AND at.app_id = apt.app_id"))
{
	echo "Error Removing Application Profile";
}

?>