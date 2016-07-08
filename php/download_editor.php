<?php
@session_start();
include("vars.php");
open_db();

$download_id = 0;

?>

<script language="javascript" type="text/javascript">

function displayAlert(string)
{
	alert(string);
}
</script>   

<div id="test_div"></div>
<div id="centerdiv" align="center">
<form enctype="multipart/form-data" target="upload_target" action="php/file_upload.php" method="POST" name="downloadform" onSubmit="startUpload()">
<input type="hidden" name="username" value="<?=getCurrentUsername()?>">
<input type="hidden" name="mode" value="upload">
<input type="hidden" name="MAX_FILE_SIZE" value="1024000000" />
<table class="table-responsive table-condensed">
<tr>
	<td colspan="4" id="msg" align="center">
    <p id="f1_upload_process">Uploading...<br/><img src="images/uploader_images/loader.gif" /><br/></p>
    </td>
</tr>
<tr>
<tr> 
	<td colspan="2">
    	<h1><span class="glyphicon glyphicon-cloud-upload"></span> Upload Here</h1>
    </td>
</tr>
<tr>
<td valign="top">
<font size="1">Choose a file to upload&nbsp;(required):</font></td>
<td > <div id="f1_upload_form" style="height:25px"><input name="uploadedfile" type="file" id="uploadedfile" value="<?=$_REQUEST['uploadedfile']?>" /></div>
</td>
	
</tr>

<tr>
<td>
	<font size="1">Display&nbsp;Name :</font></td>
<td>
	<input name="download_name" class="span3 form-control" id="download_name" value="<?=$_REQUEST['download_name']?>" placeholder="Enter Short Description Here..."/>
</td>

</tr>

<?php 

$public_group_res = mysqli_query($db,"SELECT * FROM download_groups_tab WHERE isPublic = 1");
$private_group_res = mysqli_query($db,"SELECT * FROM download_groups_tab WHERE isPublic = 0");
$type_res = mysqli_query($db,"select * from download_category_tab");

?>
<tr>
	<td>
    </td>
    <td align="left">
    <div align="center">
    <div class="input-group span4">
    <span class="input-group-addon">
    	<input type="radio" name="group_radio" checked="checked" value="public_radio"/>
        </span>
    	<select name="download_group_public" id="download_group_public" style="padding:0px; font-size:medium;font-weight:bold" class="form-control">
    	<option value="0" selected>-- PUBLIC DISCUSSION GROUP --</option>
	<?php 
	while($type_row = mysqli_fetch_array($public_group_res,MYSQL_ASSOC))
	{
	?>
	<option value="<?=$type_row['ID']?>"><?=ucfirst($type_row['group_name'])?></option>
    <?php } ?>
</select>
</div>

<div class="input-group span4">
<span class="input-group-addon">
    	<input type="radio" name="group_radio" value="private_radio"/>
        </span>
<select name="download_group_private" id="download_group_private" style="padding:0px; font-size:medium;font-weight:bold" class="form-control">
    	<option value="0" selected>-- PRIVATE DISCUSSION GROUP --</option>
	<?php 
	while($type_row = mysqli_fetch_array($private_group_res,MYSQL_ASSOC))
	{
	?>
	<option value="<?=$type_row['ID']?>"><?=ucfirst($type_row['group_name'])?></option>
    <?php } ?>
</select>
</div>
<input type="text" id="private_group_name" placeholder="New Private Group Name..." class="form-control span4"/>
</div>
    </td>
</tr>
<tr>
<td valign="top">
<font size="1">Description:</font></td><td>
	<textarea name="description" id="description" class="span4 form-control" placeholder="Enter Detailed Description Here..."><?=$_REQUEST['description']?></textarea>
</td>


</tr>

<tr>
	<td valign="top"><font size="1">Sharing&nbsp;Permissions:</font></td>
	<td>
    	<table>
        	<tr>
            	<td>
    				<select multiple class="span4 form-control" id="permissions_list">
        				<option value="0">ALL USERS</option>
        			</select><br>
                    <input type="text" class="span4 form-control" id="username_input" placeholder="Enter Username Here..."/>
               	</td>
            </tr>
            <tr>
            	<td align="left">
                	<input type="button" value="add" class="btn btn-default btn-xs" onClick="addDownloadPermission('username_input'); return false;"><input type="button" value="remove" class="btn btn-default btn-xs" onClick="removeFromList()"><input type="hidden" id="ListStr" name="ListStr">
                </td>
            </tr>
            </table>
	</td>
    

</tr>
<tr>
	<td colspan="2" align="right">
		<button type="submit" class="btn btn-success"/><span class="glyphicon glyphicon-cloud-upload"></span> Upload File</button>
	</td>
</tr>
</table>

<iframe id="upload_target" name="upload_target" style="width:0px;height:0px;"></iframe>
</form>
<div id="testDiv"></div>
<?php 
close_db();
?>
</div>
<div id="listdiv"></div>
<div id="download_msg"></div>



