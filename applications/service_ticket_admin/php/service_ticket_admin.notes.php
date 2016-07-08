<?php
include("../../../php/vars.php");
open_db();
$username = getCurrentUsername();
$service_ticket_id = $_REQUEST['service_ticket_id'];

$notes_res = mysqli_query($db,"SELECT * FROM service_ticket_note_tab WHERE service_ticket_id = $service_ticket_id ORDER BY date_added DESC");
?>
<table class="table">
<?php

if(mysqli_num_rows($notes_res) == 0)
{
?>

<tr>
<td>
<center><h1>No Comment Yet, Check Again Later</h1></center>
</td>
</tr>
</table>
 <?php
	//die();
}
else
{
?>
<table class="table">
<tr>
	<td align="center">
    	<h1>Ticket Comments</h1>
    </td>
</tr>
<tr>
	<td>
    <div>
<?php
while($note_row = mysqli_fetch_array($notes_res))
{
?>
	
<div class="media" style="text-align:left">
	
		<a href="#" class="pull-left"><img src="php/findDefaultProfileImg.php?username=<?=$note_row['from']?>&dim=50x50" width="50" class="img-circle img-retina" border="0"/></a>
        <div class="media-body">
    	<span class="media-heading"><h4><a href="#"><?=getUserFullName($note_row['from'])?></a></h4><span style="color:#CCC"><span class="glyphicon glyphicon-calendar"></span><?=date("F d, Y g:i A",strtotime($note_row['date_added']))?>:</span></span><br>
        <span class="glyphicon glyphicon-comment"></span> <?=stripslashes($note_row['note'])?> 
       </div>
</div>
       
    
 <?php
 }
 ?>
 </div>
 </td>
 </tr>
 


<?php
}
?>
<tr>
 	<td>
    	<input type="button" value="Ticket Details" onclick="showPopup3('applications/service_ticket_admin/php/service_ticket_admin.issue.edit.php','ticket_id=<?=$_REQUEST['service_ticket_id']?>','getTasks();getNote(\'\')')" class="btn"/>
    </td>
 </tr>
</table>
