<?php
$user_id = $_REQUEST['user_id'];
include("../../../php/vars.php");
open_db();
mysqli_query($db,"DELETE FROM user_tab WHERE user_id = '$user_id'");
close_db();

?>