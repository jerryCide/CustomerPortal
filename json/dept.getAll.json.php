<?php
include("../php/vars.php");
open_db();
$res = mysqli_query($db,"SELECT * FROM dept_tab WHERE ou_map != 'null' ORDER BY dept_name");

$result = array();

while($row = mysqli_fetch_array($res))
{
    array_push($result,array("dept_name" => $row['dept_name'],"dept_id" => $row['dept_id']));
}

echo json_encode($result);
?>