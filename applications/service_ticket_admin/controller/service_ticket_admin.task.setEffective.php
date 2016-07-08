<?php
if(empty($_REQUEST['task_id']))exit;

$task_id = $_REQUEST['task_id'];
include("../../../php/vars.php");
open_db();
if(!mysqli_query($db,"UPDATE service_ticket_task_tab SET isEffective = 1 WHERE ID = $task_id"))
{
	$response['isError'] =  1;
	$response['msg'] = mysqli_error($db);	
}
else
{
	$response['isError'] =  0;
	$response['msg'] =  "Task ID: $task_id";
}
close_db();

echo json_encode($response);
?>