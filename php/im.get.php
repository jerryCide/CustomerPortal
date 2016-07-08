<?php
$im_id = $_REQUEST['msg_id'];
include("vars.php");
open_db();
$res = mysqli_query($db,"SELECT * FROM im_tab WHERE im_id = $im_id");
$row = mysqli_fetch_array($res);
//mysqli_query($db,"UPDATE im_tab SET date_recv = '$today' WHERE im_id = $im_id");
close_db();

?>

<input type="hidden" id="im_<?=$im_id?>">
<div id="im_msg_<?=$im_id?>"><?=$row['msg']?></div>
<div id="im_sender_<?=$im_id?>"><?=getUserFullName($row['sender'])?></div>
<div id="im_sender_username_<?=$im_id?>"><?=$row['sender']?></div>
<div id="im_date_<?=$im_id?>"><?=date("F d, Y H:i:s",$row['date_sent'])?></div>