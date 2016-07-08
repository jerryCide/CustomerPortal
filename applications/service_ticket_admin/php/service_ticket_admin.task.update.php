<?php
if(empty($_REQUEST['task_list_string']))
{
	die("No Task List String Provided");
}


$task_list_string = $_REQUEST['task_list_string'];

$tasksArray = explode(";",$task_list_string);

include("../../../php/vars.php");
open_db();


foreach($tasksArray as $key=>$value)
{
	$listItem = explode(":",$value);
	$order = $listItem[0];
	$task_id =  $listItem[1];
	$task = stripslashes($listItem[2]);
	
	if(empty($tasksArray[$key])) continue;
	
	mysqli_query($db,"UPDATE service_ticket_task_tab SET `order` = $order WHERE ID = $task_id");
	
}


close_db();

?>