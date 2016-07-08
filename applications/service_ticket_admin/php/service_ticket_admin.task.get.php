<?php
include("../../../php/vars.php");
$service_ticket_id = $_REQUEST['service_ticket_id'];

open_db();
$res = mysqli_query($db,"SELECT * FROM service_ticket_task_tab WHERE service_ticket_id = $service_ticket_id ORDER BY `order`");
close_db();
?>
<ul id="tasks_list" style="visibility:hidden">
<?php
while($row = mysqli_fetch_array($res))
{
	?>
    <LI value="<?=$row['ID']?>" title="<?=$row['task']?>"><?=$row['isEffective']==1?"✔":""?> <?=$row['task']?> [ <?=$row['administrator']?> ]</LI>
    <?php
}
?>
</ul>