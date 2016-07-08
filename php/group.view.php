<?php
if(empty($_REQUEST['group_id']))
{ 
	die("No Group ID Passed"); 
}
$group_id = $_REQUEST['group_id'];

include("vars.php");
open_db();
$res = mysqli_query($db,"SELECT * FROM download_groups_tab WHERE ID = $group_id");
$files_res = mysqli_query($db,"SELECT * FROM download_tab WHERE category_id = $group_id ORDER BY date_added DESC");
close_db();
$row = mysqli_fetch_array($res);
?>

<h3><font color="#999999">Group:</font><?=$row['group_name']?></h3>

<div>

<?php
while($files_row = mysqli_fetch_array($files_res))
{
?>
	<a href="#" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="<?=$files_row['download_name']?>" onClick="showPopup3('php/share.view.php','download_id=<?=$files_row['download_id']?>','');"><span class="glyphicon glyphicon-file"></span> <?=substr($files_row['download_name'],0,15)?></a>
    
<?php	
}
?>

</div>
<div style="height:400px">
</div>