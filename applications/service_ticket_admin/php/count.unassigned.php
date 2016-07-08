<?php
include("../../../php/vars.php");
open_db();
$res = mysqli_query($db,"SELECT count(*) as count FROM service_ticket_tab WHERE service_ticket_status = 1");
close_db();

$row = mysqli_fetch_array($res);

?>
<input type="hidden" value="<?=$row['count']?>" id="countUnassigned">