<?php
$username = $_REQUEST['username'];
$service_ticket_id = $_REQUEST['service_ticket_id'];
include("../../../php/vars.php");

open_db();
mysqli_query($db,"DELETE FROM service_ticket_assignment_tab WHERE service_ticket_id = $service_ticket_id AND username = '$username'");

$res = mysqli_query($db,"SELECT * FROM service_ticket_assignment_tab WHERE service_ticket_id = $service_ticket_id");

if(mysqli_num_rows($res) == 0)
{
	mysqli_query($db,"UPDATE service_ticket_tab SET service_ticket_status = 1 WHERE service_ticket_id = $service_ticket_id");	
}
close_db();
?>