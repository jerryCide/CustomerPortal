<?php //file updates deadlines lists for ticket only

if(empty($_REQUEST['service_ticket_id']))
{
	die("No Service Ticket ID Provided");
}

include("../../../php/vars.php");
open_db();

$service_ticket_id = $_REQUEST['service_ticket_id'];
$service_ticket_desc = addslashes($_REQUEST['service_ticket_desc']);

$deadline = $_REQUEST['deadline'];

$chk_res = mysqli_query($db,"SELECT * FROM service_ticket_deadlines WHERE service_ticket_id = $service_ticket_id AND deadline LIKE '$deadline%'");
	
if(mysqli_num_rows($chk_res) == 0)
{
	mysqli_query($db,"INSERT INTO service_ticket_deadlines(deadline,service_ticket_id) VALUES('$deadline',$service_ticket_id)");
}


if(!empty($_REQUEST['service_ticket_desc']))
{
	mysqli_query($db,"UPDATE service_ticket_tab SET service_ticket_desc = '$service_ticket_desc' WHERE service_ticket_id = $service_ticket_id");
}


close_db();
	
?>
<input type="hidden" id="isError" value="0" />
   