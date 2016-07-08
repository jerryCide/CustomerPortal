<?php
include("../../../php/vars.php");
$app_id = $_REQUEST['app_id'];
$lock_val = $_REQUEST['lock_val'];

open_db();
mysqli_query($db,"UPDATE app_tab SET app_isonline = $lock_val WHERE app_id = $app_id");
close_db();
?>