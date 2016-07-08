<?php
include("../../../php/vars.php");

$ou_map = $_REQUEST['selected_ou'];
$dept_id = $_REQUEST['dept_id'];

open_db();
mysqli_query($db,"UPDATE dept_tab SET ou_map = '$ou_map' WHERE dept_id = $dept_id");
close_db();
?>