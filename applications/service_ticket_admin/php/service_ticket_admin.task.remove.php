<?php
if(empty($_REQUEST['task_id']))
{
	die("No Task ID Given");
}



$task_id = $_REQUEST['task_id'];

include("../../../php/vars.php");
$username = getCurrentUsername();
open_db();
//echo "DELETE FROM service_ticket_task_tab WHERE ID = $task_id AND `administrator` = '$username'";
if(!mysqli_query($db,"DELETE FROM service_ticket_task_tab WHERE ID = $task_id AND `administrator` = '$username'"))
{
	?>
	<input type="hidden" id="isError" value="1">
    <input type="hidden" id="errorMsg" value="Cannot Remove Task, You can only delete your own task">  
	<?php	
}
else
{
	
?>
	<input type="hidden" id="isError" value="0">
      
	<?php	
}
close_db();

?>