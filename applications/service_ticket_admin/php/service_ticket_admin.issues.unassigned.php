<h1>Unassigned Tickets</h1>
<?php

$status_id = 1;		

if(empty($_REQUEST['scope']))
{
	$query = "SELECT *,(SELECT MAX(deadline) FROM service_ticket_deadlines WHERE service_ticket_id = stt.service_ticket_id) deadline 
	FROM service_ticket_tab as stt, service_ticket_status_type_tab as sts, service_ticket_type_tab sttt WHERE stt.service_ticket_status = $status_id AND stt.service_ticket_status = sts.service_ticket_status_type_id AND sttt.service_ticket_type_id = stt.service_ticket_type_id";

}
else if($_REQUEST['scope'] == "user")
{
	" AND sta.username = '$username'";	
}
else if($_REQUEST['scope'] == "all")
{
	$query = "SELECT *,(SELECT MAX(deadline) FROM service_ticket_deadlines WHERE service_ticket_id = stt.service_ticket_id) deadline
	FROM service_ticket_tab as stt, service_ticket_status_type_tab as sts, service_ticket_type_tab sttt WHERE stt.service_ticket_status = $status_id AND stt.service_ticket_status = sts.service_ticket_status_type_id AND sttt.service_ticket_type_id = stt.service_ticket_type_id";

}


include("../../../php/vars.php");
open_db();
$username = $session_user->username;


$open_res = mysqli_query($db,$query);

close_db();
?>
<center>
<table width="890px">
	<tr>
    	<td align="center">
         	<h1>All Open Tickets</h1>
        </td>
    </tr>
    <tr>
    	<td>
        	
        </td>
    </tr>
    <tr>
    	<td align="center">
        	
        	<?php
			
			if(mysqli_num_rows($open_res) == 0)
			{?>            
				<h2>No Unassigned Tickets</h2>	
                <?php
			}
            while($open_row = mysqli_fetch_array($open_res,MYSQL_ASSOC))
			{
				?>
                <table width="100%" bgcolor="#DDDDDD" style="border:1px #999 solid" class="table <?php if($open_row['service_ticket_status'] == 1){ echo "unassigned"; }else if($open_row['service_ticket_status'] == 2){ echo "closedResolved"; }else if($open_row['service_ticket_status'] == 3){ echo "closedRejected"; } else if($open_row['service_ticket_status'] == 5){ echo "closedUnresolved"; }else if($open_row['service_ticket_status'] == 6){ echo "assigned"; }?>">
                <tr>
                	<td colspan="2" align="left">
                    <div>
                    <div style="float:left; position:absolute;">
                    <b>Ticket#:</b> <font color="#060" size="+3"><b><?=$open_row['service_ticket_id']?></b></font>
                    </div>
                    <div style="float:right">
                    	<b>Status:</b>&nbsp;<font size="+1" color="#666666"><b><?=$open_row['service_ticket_status_type']?></b></font>
                    </div>
                    </div>
                    </td>
                </tr>
                <tr>
                	<td width="70%" valign="top">
                    	<div style="width:auto">
                    	<div style="float:left; width:10%"><img src="php/findDefaultProfileImg.php?username=<?=$open_row['service_ticket_owner']?>&dim=50x50" width="50" class="profilePhoto"/></div>
                        <div style="float:left; text-align:left; width:85%">
                        &nbsp;&nbsp;<b><font size="+1"><?=stripslashes($open_row['service_ticket_type'])?></font></b>
                        <hr> 
                        
                        &nbsp;&nbsp;<b>Client Name:</b> <?php if($open_row['owner_fName'] == "" && $open_row['owner_lName'] == ""){ echo getUserFullName($open_row['service_ticket_owner']); }?> <?=$open_row['owner_fName']?> <?=$open_row['owner_lName']?><br>
                        &nbsp;&nbsp;<b>Reported By: </b> <?=getUserFullName($open_row['added_by'])?><br>
                        &nbsp;&nbsp;<b>Date: </b> <?=date("F d, Y g:i A",strtotime($open_row['service_ticket_sdate']))?><br>
                        <hr>
                        &nbsp;&nbsp;<b>Desc:</b> <?=$open_row['service_ticket_desc']?>
                        </div>
                        </div>
                    </td>
                    <td width="11%" align="left" valign="top" rowspan="2">
                    	<div></div>
                        <div></div><br>
                        <?php  if($open_row['deadline'] != "0000-00-00 00:00:00")
						{ 
							$date_diff_array = date_diff2($open_row['deadline'],$today);
						?>
                        <b>Deadline:</b><br>
                        <?=date("M d Y",strtotime($open_row['deadline']))?><br>
                        
                        
                        <b>Due In:</b><br>
      					<font size="+1"><b><?=1+$date_diff_array['day']." DAY(S)<br>".$date_diff_array['hour']." HR(S)"?></b></font>
                        
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                	<td align="left">
                    	<button class="btn btn-primary" onclick="showPopup3('applications/service_ticket_admin/php/service_ticket_admin.issue.edit.php','ticket_id=<?=$open_row['service_ticket_id']?>','getTasks();getNote(\'\')');registerDatePickerInput('deadline')"><i class="icon-pencil icon-white"></i> View/Edit</button>
                    	
                         <button onclick="showPopup3('applications/service_ticket_admin/php/service_ticket_admin.notes.php','service_ticket_id=<?=$open_row['service_ticket_id']?>',''); return false;" class="btn btn-danger"><i class="icon-comment icon-white"></i> Comments</button>
                         
                    </td>
                    
                </tr>
                </table>
                <br>
                
				<?php	
			}
			?>
           
        </td>
    </tr>
</table>
</center>