<?php
include("../../../php/vars.php");

if(empty($_REQUEST['search_str']))
{
	die();	
}

$search_str = $_REQUEST['search_str'];
open_db();
$sender_res = mysqli_query($db,"SELECT incoming_id,sender FROM mail_corr_incoming WHERE LOWER(sender) LIKE '$search_str%' GROUP BY sender");
close_db();
?>

<table width="100%" cellpadding="0" bgcolor="#FFFFFF">
<?php
while($sender_row = mysqli_fetch_array($sender_res,MYSQL_ASSOC))
{

?>
	<tr>	
    	<td height="50" background="/images/bgz/list_bg_50.jpg" style="background-repeat:repeat-x; cursor:pointer;" valign="middle" onClick="insertSender('sender_<?=$sender_row['incoming_id']?>')"><h3><?=$sender_row['sender']?></h3>
           <input type="hidden" id="sender_<?=$sender_row['incoming_id']?>" value="<?=$sender_row['sender']?>"> 
        </td>
    </tr>
    <?php
}
	?>
</table>

