<?php
$app_map_id = $_REQUEST['app_map_id'];

include("../../../php/vars.php");
open_db();
mysqli_query($db,"DELETE FROM app_permission_tab WHERE app_map_id = $app_map_id");
close_db();
?>