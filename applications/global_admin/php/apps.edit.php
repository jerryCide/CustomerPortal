
<?php
include("../../../php/vars.php");
$app_id = $_REQUEST['app_id'];
open_db();
$apps_res = mysqli_query($db,"select * from app_tab as at LEFT OUTER JOIN app_permission_tab as apt ON at.app_id = apt.app_id WHERE at.app_id = $app_id");
close_db();
$apps_row = mysqli_fetch_array($apps_res,MYSQL_ASSOC);

?>

<table width="600" class="table table-responsive">
	<tr>
    	<td width="164">
        	<b>Application&nbsp;Name:</b>
        </td>
        <td width="539">
        	<input type="input" value="<?=$apps_row['app_name']?>" id="app_name" style="width:250px">
        </td>
    </tr>
    <tr>
    	<td>
        	<b>Application&nbsp;Directory:</b>
        </td>
        <td>
        	<input type="input" value="<?=$apps_row['app_dir']?>" id="app_dir" style="width:250px">
        </td>
    </tr>
    <tr>
    	<td>
        	<b>Application&nbsp;Online:</b>
        </td>
        <td align="left">
        	<input type="checkbox" value="<?=$apps_row['app_name']?>" id="app_isonline" <?php if($apps_row['app_isonline']){ ?> checked<?php }?>>
        </td>
    </tr>
    <tr>
    	<td>
        	<b>Application&nbsp;Scope:</b>
        </td>
        <td align="left">
        <div class="input-append">	
        	<label for="private">Private
            <input type="radio" id="private" name="app_scope" onclick="checkScope()" <?php if($apps_row['app_isPrivate']==1){ ?> checked="checked"<? } ?>>
            </label>
            </div>
            
            <div class="input-append">	<label for="public">Public
            <input type="radio" id="public" name="app_scope" onclick="checkScope()" <?php if($apps_row['app_isPrivate']==0){ ?> checked="checked"<? } ?>>
            </label>
            </div>
        </td>
    </tr>
    <tr>
    	<td valign="top">
        	<b>Users:</b>
        </td>
        <td>
        	<div>
            	Users:<br>
            </div>
            <div id="supervisors">
            </div>
        	<?php 
			if($apps_row['app_isPrivate'] == 0)
			{ 
			?>
          <script>
				document.getElementById('app_users').disabled = true;
			</script>
			<?php 
			} ?>
       	  <div id="app_users">
          	<?php
            open_db();
$user_res = mysqli_query($db,"SELECT * FROM app_permission_tab WHERE app_id = $app_id");
close_db();
			?>
          	<select size="6" id="userList" style="width:250px"></select>
          </div>
            <span id="commands"><input type="input" id="username_input" class="username_input" style="width:250px" autocomplete="off">&nbsp;
            
            
            <div class="input-append">
            	<label for="isSupervisor">
            		<input type="checkbox" name="isSupervisor" id="isSupervisor" />&nbsp;Supervisor
                </label>
            </div>
            <br>
            <input type="button" value="Add" onclick="addUser(<?=$app_id?>)" id="add_button" class="btn btn-mini"/>
            &nbsp;<input type="button" value="Delete" onClick="deleteUser()" id="del_button" class="btn btn-mini"></span>
            <input type="hidden" id="curr_user">
            <input type="hidden" id="user_list">
        </td>
    </tr>
    <tr>
    	<td colspan="2" id="addu_msg"> 
        </td>
    </tr>
    <tr>
    	<td colspan="2" align="right">
        <hr>
        	<input type="button" value="Save" onClick="saveApp(<?=$app_id?>);" class="btn btn-success">&nbsp;&nbsp;<input type="button" value="Close" onClick="hidebox();" class="btn btn-inverse">
        </td>
    </tr>
</table>
<div id="test_div"></div>
<style>
.ui-autocomplete-input{z-index:1151;}
</style>

