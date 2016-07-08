<h1>Service Ticket - Home</h1>
<center>
<?php
@include("../../../php/vars.php");

$query = "SELECT *,(SELECT MAX(deadline) FROM service_ticket_deadlines WHERE service_ticket_id = stt.service_ticket_id) as deadline 
FROM service_ticket_tab stt, service_ticket_status_type_tab sts, service_ticket_assignment_tab sta,service_ticket_type_tab sttt 
WHERE stt.service_ticket_status = sts.service_ticket_status_type_id AND sta.service_ticket_id = stt.service_ticket_id AND (stt.service_ticket_status = 1 OR stt.service_ticket_status = 6) AND sttt.service_ticket_type_id = stt.service_ticket_type_id AND sta.username = '".getCurrentUsername()."'";

//echo $query;
$msg = "Open Tickets Assigned to you";
$msg2 = "The following are tickets assigned to you, please complete these as soon as possible";



open_db();

$open_res = mysqli_query($db,$query);
$res_res = mysqli_query($db,"SELECT * FROM service_ticket_tab where service_ticket_sdate != '0000-00-00 00:00:00' ");

if(mysqli_num_rows($open_res) == 0)
{
	$query = "SELECT *,(SELECT MAX(deadline) FROM service_ticket_deadlines WHERE service_ticket_id = stt.service_ticket_id) as deadline 
	FROM service_ticket_tab stt, service_ticket_status_type_tab sts,service_ticket_type_tab sttt 
				WHERE stt.service_ticket_status = sts.service_ticket_status_type_id 
					AND stt.service_ticket_status = 1 AND sttt.service_ticket_type_id = stt.service_ticket_type_id";	
	
	$msg = "Other Tickets";
	$msg2 = "The following are open tickets not assigned to anyone, please complete these as soon as possible";	
}


$open_res = @mysqli_query($db,$query);
//echo $query;
close_db();

$count = 0;
$totalHours = 0;
while($res_row =  mysqli_fetch_array($res_res))
{
	if($res_row['service_ticket_cdate'] ==  "0000-00-00 00:00:00")
	{
		$time_diff = date_diff2($res_row['service_ticket_sdate'],$today);	
	}
	else
	{
		$time_diff = date_diff2($res_row['service_ticket_sdate'],$res_row['service_ticket_cdate']);	
		}
	
	$count++;
	$totalHours += $time_diff['hour'];
}


?>
<br>
<table width="800px">
	<tr>
    	<td align="center">
        	<?="<b>Average Ticket Time:</b>  ".round(($totalHours/$count),2)." Hours"?>
        </td>
    </tr>
	<tr>
    	<td align="center"><h1><?=$msg?></h1></td>
    </tr>
    <tr>
    	<td align="center">
        	<?=$msg2?>
        </td>
    </tr>
    <tr>
    	<td>
        <br />
        <br />
        

<table width="890px">
	<tr>
    	<td align="center">
        	
        	<?php
			
			if(mysqli_num_rows($open_res) == 0)
			{?>            
				<h2>No Tickets Found</h2>
                <?php
				//die("--");
			}
			else
			{
            	while($open_row = mysqli_fetch_array($open_res))
				{
				?>
                	<div id="ticket_<?=$open_row['service_ticket_id']?>" class="well">
                <table width="100%" bgcolor="#DDDDDD" class="table <?php if($open_row['service_ticket_status'] == 1){ echo "unassigned"; }else if($open_row['service_ticket_status'] == 2){ echo "closedResolved"; }else if($open_row['service_ticket_status'] == 3){ echo "closedRejected"; } else if($open_row['service_ticket_status'] == 5){ echo "closedUnresolved"; }else if($open_row['service_ticket_status'] == 6){ echo "assigned"; }?> table-condensed table-responsive">
                <tr>
                	<td colspan="2" align="left">
                    <div>
                    <div style="float:left; position:absolute;">
                    <b>Ticket#:</b> <font color="#060" size="+3"><b><?=$open_row['service_ticket_id']?></b></font>
                    <b><font size="+1"><?=stripslashes($open_row['service_ticket_type'])?></font></b>
                    </div>
                    <div style="float:right">
                    	
                        
                        <?php
                        	open_db();
							$assign_list_res = mysqli_query($db,"SELECT * FROM service_ticket_assignment_tab WHERE service_ticket_id = ".$open_row['service_ticket_id']);
							close_db();
						?>
                        
                        <div class="btn-group">
          					<a class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
            					<i class="icon-th-list icon-white"></i>&nbsp;Assigned&nbsp;<span class="caret"></span>
          					</a>
          					<ul class="dropdown-menu">
                            	<li>
                                <?php
                                while($assign_list_row = mysqli_fetch_array($assign_list_res))
								{
								?> <a href="#" onclick="return false;"><b><span class="glyphicon glyphicon-user"></span>&nbsp;<?=getUserFullName($assign_list_row['username'])?></b> <?=date("M-j-Y [H:i a]",strtotime($assign_list_row['date_assigned']))?></a>
                                 <?php 
								}
								 ?>
                                </li>
          					</ul>
        				</div>
                        
                       
                        
                        
                    </div>
                    </div>
                    </td>
                </tr>
                <tr>
                	<td width="70%" valign="top">
                    	<div style="width:auto">
                    	<div style="float:left; width:10%"><img src="php/findDefaultProfileImg.php?username=<?=$open_row['service_ticket_owner']?>&dim=50x50" width="50" class="profilePhoto img-circle"/></div>
                        <div style="float:left; text-align:left; width:85%">
                        
                        
                       <b>Client Name:</b> <?php if($open_row['owner_fName'] == "" && $open_row['owner_lName'] == ""){ echo getUserFullName($open_row['service_ticket_owner']); }?> <?=$open_row['owner_fName']?> <?=$open_row['owner_lName']?><br>
                       <b>Reported By:</b> <?=getUserFullName($open_row['added_by'])?><br>
                       <b>Date: </b> <?=date("F d, Y g:i A",strtotime($open_row['service_ticket_sdate']))?><br>
                       
                       <b>Desc:</b> <span id="ticket_<?=$open_row['service_ticket_id']?>"><?=$open_row['service_ticket_desc']?></span>
                        </div>
                        </div>
                    </td>
                    <td width="11%" align="left" valign="top" rowspan="2">
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
                	<td align="left" colspan="2">
                    	<button class="btn btn-primary" onclick="showPopup3('applications/service_ticket_admin/php/service_ticket_admin.issue.edit.php','ticket_id=<?=$open_row['service_ticket_id']?>','getTasks();getNote(\'\')');registerDatePickerInput('deadline');"><span class="glyphicon glyphicon-pencil"></span> View/Edit</button>
                    	
                         <button onclick="showPopup3('applications/service_ticket_admin/php/service_ticket_admin.notes.php','service_ticket_id=<?=$open_row['service_ticket_id']?>',''); return false;" class="btn btn-danger"><span class="glyphicon glyphicon-comment"></span> Comments</button>
                         
                         <button onclick="showPopup3('applications/service_ticket_admin/php/service_ticket_admin.task.display.php','service_ticket_id=<?=$open_row['service_ticket_id']?>',''); return false;" class="btn btn-danger"><span class="glyphicon glyphicon-bullhorn"></span> Tasks</button>
                         
                 <div class="btn-group">        
                <button class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-ban-circle"></span> Cancel Ticket <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a href="#" onclick="showPopup3('applications/service_ticket_admin/modals/service_ticket_admin.rejectTicket.form.php','service_ticket_id=<?=$open_row['service_ticket_id']?>',''); return false;"><span class="glyphicon glyphicon-remove" style="color:red"></span> Rejected</a></li> 
                  <li><a href="#" onclick="unresolveTicket(<?=$open_row['service_ticket_id']?>,'<?=getCurrentUsername()?>'); return false;"><i class="glyphicon glyphicon-trash"></i> Unresolved</a></li>                </ul>
                  </div>
              
            </div> 
                         
                    </td>
                    
                </tr>
                </table>
                </div>
                
                <?php
				}
			}
				?>
				
           
        </td>
    </tr>
</table>

<?php
$results_count = mysqli_num_rows($open_res);
?>

<input type="hidden" value="<?=$results_count?>" id="results_count" />	
        </td>
    </tr>
</table>
</center>