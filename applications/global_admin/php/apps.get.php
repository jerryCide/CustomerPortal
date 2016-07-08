<?php
include("../../../php/vars.php");
open_db();
$apps_res = mysqli_query($db,"SELECT * FROM app_tab ORDER BY app_name");
close_db();

?>

<table class="table table-stripe table-hover span8">
<tr>
	<td colspan="2">
    	<a href="#" class="btn btn-success btn-large" onClick="showPopup3('applications/global_admin/php/apps.showall.php',''); return false;"><span class="glyphicon glyphicon-plus"></span> Add Application</a>    
    </td>
</tr>
<tr>
    	<td colspan="2">
        	<h1>Application Name</h1>
        </td>
        
    </tr>
<?php
while($apps_row = mysqli_fetch_array($apps_res,MYSQL_ASSOC))
{
?>
	<tr style="border-bottom:1px #00000 solid;">
    	<td>
        	<b><font size="2px" style="color:#000"><a href="#" onClick="showPopup3('applications/global_admin/php/apps.edit.php','app_id=<?=$apps_row['app_id']?>','getAppUsers(<?=$apps_row['app_id']?>)'); return false;"><?=$apps_row['app_name']?></a></font></b>
        </td>
      <td align="left">

       	<input type="button" value="Edit" class="btn btn-default" onClick="showPopup3('applications/global_admin/php/apps.edit.php','app_id=<?=$apps_row['app_id']?>','getAppUsers(<?=$apps_row['app_id']?>)'); return false;" >&nbsp;<input type="button" value="Uninstall" onClick="uninstallApp(<?=$apps_row['app_id']?>)" class="btn btn-danger <?php if($apps_row['app_isSticky'] == 1){ ?> disabled <?php } ?>"><?php if($apps_row['app_isonline']){ ?>
       	<input type="button" value="Disable" onClick="lockApp(0,<?=$apps_row['app_id']?>)" class="btn btn-danger">
       	<?php }else{ ?> <input type="button" value="Enable" onClick="lockApp(1,<?=$apps_row['app_id']?>)" class="btn"><?php } ?>
      </td>
    </tr>
    <?php
}
	?>
</table>