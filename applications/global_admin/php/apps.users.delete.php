<?php
include("../../../php/vars.php");
$app_map_id = $_REQUEST['app_map_id'];
open_db();
if(!mysqli_query($db,"DELETE FROM app_permission_tab WHERE app_map_id = $app_map_id"))
{
	echo "Deleting Failed";	
}
close_db();

?>