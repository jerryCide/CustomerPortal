<?php
include("../../../php/vars.php");

open_db();

$res = mysqli_query($db,"SELECT * FROM dept_tab");
close_db();

$data = array();
while($row =  mysqli_fetch_array($res))
{
	array_push($data,array("dept_id" => $row['dept_id'],"dept_name" => $row['dept_name'],"ou_map" => $row['ou_map'],"isValid" => $row['isValid']));
}

echo json_encode($data); //encode output to json for consumption
?>