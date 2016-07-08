<?php
include("../../../php/vars.php");
open_db();
$res = mysqli_query($db,"SELECT count(*) as count FROM service_ticket_tab st,service_ticket_assignment_tab sta WHERE st.service_ticket_id = sta.service_ticket_id AND service_ticket_status = 6 AND sta.username = '".getCurrentUsername()."'");
close_db();

$row = mysqli_fetch_array($res);

?>
<input type="hidden" value="<?=$row['count']?>" id="countAssigned">