<?php
include("vars.php");
$username = getCurrentUsername();
if(empty($username))
{
	die("<center><h1>You Must Login To View This Section</h1><br><a href=\"#\" onClick=\"document.getElementById('login_child').style.visibility='visible'\">Login Here</a></center>");
}
else
{
	if(!empty($_REQUEST['download_id']))
	{
		$download_id = $_REQUEST['download_id'];
		open_db();
		$res = mysqli_query($db,"SELECT * FROM download_tab WHERE download_id = $download_id");
		$row = mysqli_fetch_array($res,MYSQL_ASSOC);
		close_db();
	}



?>

<table width="600px" bgcolor="#FFFFFF" class="table-responsive table-condensed">
	
<tr>
    	
    <td width="82%">
    
    <?php
    if(mysqli_num_rows($res) == 0)
	{
		echo "<center>Opps! Invalid Download</center>";	
	}
	else
	{
	?>
			<table width="100%" class="table-condensed table-responsive">
            	<tr>
                	<td style="border-bottom:2px #CCCCCC solid">
                    	<h1><?=ucwords($row['download_name'])?></h1>                  
                    </td>
                </tr>
                <tr>
                	<td>
                    	<b>Description</b>                    
                    </td>
                </tr>
                <tr>
                	<td>
                    	<i><?=date("M d Y G:i a",strtotime($row['date_added']))?></i><br>
                    	<?=$row['description']?>
                    </td>
                </tr>
                
                <tr>
                	<td>
                    	<b>File Type</b>                    </td>
                </tr>
                <tr>
                	<td>
                    	<?=$row['extension']?>                    </td>
                </tr>
                
                <tr>
                	<td>
                    	<b>Filename</b>                    </td>
                </tr>
                <tr>
                	<td>
                    	<?=$row['filename']?>                    </td>
                </tr>
                <tr>
                	<td>&nbsp;
                    	
                    
                    </td>
                </tr>
                <tr>
  	<td align="center"><?php if(!$row['readonly']){ ?><a href="php/share.download.php?download_id=<?=$row['download_id']?>" title="<?=$row['description']?> [click to download]" target="download_target" class="slink"><img src="images/site_icons/46.png" border="0"/> Download</a>&nbsp;&nbsp;&nbsp;<?php } if($row['extension'] == "audio/mpeg3" || $row['extension'] == "video/x-msvideo" || $row['extension'] == "audio/mpeg" || $row['extension'] == "video/x-ms-wmv" || $row['extension'] == "video/avi") {?><a href="?disp_page=media.video&media_id=<?=$row['download_id']?>" class="slink">Listen/Watch</a><? } ?> <button type="button" class="btn btn-info" onclick="showPopup3('php/group.view.php','',''); return false;">Group:[GName]</button>
    <iframe name="download_target" style="width:0; height:0;"></iframe>
    </td>
  </tr>
            </table>     <?php } ?> 
            
            </td>
  </tr>
  
</table>

<?php
}
?>
