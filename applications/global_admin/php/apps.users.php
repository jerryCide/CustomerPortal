<?php
$app_id = $_REQUEST['app_id'];
include("../../../php/vars.php");
open_db();
$user_res = mysqli_query($db,"SELECT * FROM app_permission_tab WHERE app_id = $app_id");
close_db();
?>

<ul id="userListDB" style="visibility:hidden">
<?php
while($user_row= mysqli_fetch_array($user_res,MYSQL_ASSOC))
{
	?>
    <LI value="<?=$user_row['app_map_id']?>"><?=$user_row['isSupervisor']==1?"*":""?> <?=$user_row['app_user_id']?></LI>
    <?php
}
?>
</ul>