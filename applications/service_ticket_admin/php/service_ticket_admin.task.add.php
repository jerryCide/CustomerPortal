<?php
if(empty($_REQUEST['service_ticket_id']))
{
	die("No Service ID Given");
}

$service_ticket_id = $_REQUEST['service_ticket_id'];
$task = addslashes($_REQUEST['task']);

include("../../../php/vars.php");
open_db();

$administrator = getCurrentUsername();

$task_res = mysqli_query($db,"SELECT `order` FROM service_ticket_task_tab WHERE service_ticket_id = $service_ticket_id ORDER BY `order` DESC LIMIT 1");
$task_row = @mysql_fetch_array($task_res);

$order_num = (mysqli_num_rows($task_res)==0?1:$task_row['order'])+1;

if(!mysqli_query($db,"INSERT INTO service_ticket_task_tab(service_ticket_id,task,date_added,`order`,administrator) VALUES($service_ticket_id,'$task','$today',$order_num,'$administrator')"))
{
	?>
	<input type="hidden" id="isError" value="1">
	<?php	
}
else
{
?>
	<input type="hidden" id="isError" value="0">
    <input type="hidden" id="task_id" value="<?=mysql_insert_id()?>">
	<?php	
}
close_db();

?>