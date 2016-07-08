<?php
$ticket_id = $_REQUEST['ticket_id'];

include("../../../php/vars.php");
open_db();
$username = $session_user->username;
$open_res = mysqli_query($db,"SELECT * FROM service_ticket_tab WHERE service_ticket_id = $ticket_id");
close_db();
?>