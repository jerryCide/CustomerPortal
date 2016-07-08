<?php
include("vars.php");
open_db();
$username = getCurrentUsername();
$download_res = mysqli_query($db,"SELECT * FROM download_permission_tab DP, download_tab D, download_groups_tab DG 
WHERE D.download_id = DP.download_id AND (DP.username = '' OR DP.username = '$username') AND D.category_id = DG.ID AND D.active = 1 ORDER BY date_added DESC LIMIT 0,5");
close_db();



?>
<div class="list-group pull-left" align="left">
  <p class="list-group-header"><b>Latest Downloads</b> <a href="#" class="btn btn-default btn-xs" onClick="showPopup3('php/download_editor.php','username=<?=$session_user->username?>&include=1',''); return false;"><span class="glyphicon glyphicon-cloud-upload"></span> Upload File</a> </p>			
<?php  			
 if(mysqli_num_rows($download_res) == 0)
 {
	?>
    <p class="list-group-item-text"><b>No Downloads Yet <span class="glyphicon glyphicon-thumbs-down"></span></b></p>	
    <?php	 
}       
while($download_row = mysqli_fetch_array($download_res))
{
	
?>
	<a href="#!" class="list-group-item" onclick="showPopup3('php/share.view.php','download_id=<?=$download_row['download_id']?>','')">
	<b class="list-group-item-heading"><span class="glyphicon glyphicon-file"></span> <?=ucwords($download_row['download_name'])?></b>
    <p class="list-group-item-text"><span class="glyphicon glyphicon-user"></span> <?=getUserFullName($download_row['user_id'])?><br><span class="glyphicon glyphicon-th"></span> <?=$download_row['group_name']?></p>
    </a>
<?php
}

$download_list = rtrim($download_list,",");
?>
<p class="list-group-footer"><b><a href="?disp_page=share"><span class="glyphicon glyphicon-hdd"></span> Shared Files</a></b> </p>
</div>
