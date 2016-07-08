<?php
include("../../../php/vars.php");
open_db();
$username = getCurrentUsername();
$service_ticket_id = $_REQUEST['service_ticket_id'];

$notes_res = mysqli_query($db,"SELECT * FROM service_ticket_task_tab WHERE service_ticket_id = $service_ticket_id ORDER BY date_added DESC");

?>
<table class="table table-no-bordered">
<?php

if(mysqli_num_rows($notes_res) == 0)
{
?>

<tr>
<td>
<center>
  <h1>No Tasks Yet, Check Again Later</h1></center>
</td>
</tr>

 <?php
	
}
else
{
?>

<tr>
	<td align="center">
    	<h1>Ticket Tasks</h1>
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
	
		<a href="#" class="pull-left"><img src="php/findDefaultProfileImg.php?username=<?=$note_row['administrator']?>&dim=50x50" width="50" class="img-circle img-retina" border="0"/></a>
        <div class="media-body">
    	<span class="media-heading"><h4><a href="#"><?=getUserFullName($note_row['administrator'])?></a></h4><span style="color:#CCC"><span class="glyphicon glyphicon-calendar"></span><?=date("F d, Y g:i A",strtotime($note_row['date_added']))?>:</span></span><br>
        <?php if($note_row['isEffective']==1){ ?><button type="button" class="btn btn-success btn-circle" disabled="disabled"><i class="glyphicon glyphicon-ok"></i></button><?php }else{ ?><span class="glyphicon glyphicon-pushpin"></span><?php } ?> <?=stripslashes($note_row['task'])?>  
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
