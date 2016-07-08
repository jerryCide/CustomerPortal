<?php 
include("../../../php/vars.php");
open_db();
$username = getCurrentUsername();
$ticket_id = $_REQUEST['ticket_id'];
$open_res = mysqli_query($db,"SELECT *,(SELECT MAX(deadline) FROM service_ticket_deadlines WHERE service_ticket_id = stt.service_ticket_id) as deadline  FROM service_ticket_tab as stt, service_ticket_status_type_tab as sts WHERE stt.service_ticket_status = sts.service_ticket_status_type_id AND service_ticket_id = $ticket_id");
$open_row = mysqli_fetch_array($open_res);
$assign_res = mysqli_query($db,"SELECT * FROM service_ticket_assignment_tab WHERE service_ticket_id = $ticket_id");

$supervisor_res = mysqli_query($db,"SELECT isSupervisor FROM app_permission_tab WHERE app_id = ".$_SESSION['app_id']." AND app_user_id = '".getCurrentUsername()."'");
$isSupervisor = mysqli_num_rows($supervisor_res) > 0?true:false;

$isAssigned_res = mysqli_query($db,"SELECT * FROM service_ticket_assignment_tab WHERE service_ticket_id = $ticket_id AND username = '$username'");
$isAssigned = mysqli_num_rows($isAssigned_res) > 0?true:false;

$ticket_res = mysqli_query($db,"SELECT * FROM service_ticket_tab WHERE service_ticket_id = $ticket_id");
$ticket_row = mysqli_fetch_array($ticket_res);

close_db();

?>


<input type="hidden" value="<?=$ticket_id?>" id="current_service_id" />
<input type="hidden" value="<?=getCurrentUsername()?>" id="current_username" />
<table class="table table-responsive table-condensed table-striped">
	
	<tr>
                	<td align="center" valign="middle" colspan="2" style="border-bottom:5px #000 solid">
                    	<div>
                        	<div style="float:left"><font size="+1" color="#009900"><h1><b style="color:#000">#:</b><?=$open_row['service_ticket_id']?></h1></font></div>                     	
                    
                    	<div style="float:left"></div>
                        <div><button onclick="showPopup3('applications/service_ticket_admin/php/service_ticket_admin.issue.edit.php','ticket_id=<?=$open_row['service_ticket_id']?>',''); setTimeout('getTasks();getNote(\'\')',500);" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-refresh"></span> Refresh Ticket</button> <button onclick="saveTicket();closePopup();return false;" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-log-in"></span> Close & Save</button></div>
                       </div>
                    </td>
                </tr>
	<tr>
    	<td align="left" colspan="2">
        <b>Submitted By:</b> <i class="icon-user"></i>&nbsp;<?=getUserFullName($open_row['added_by'])?>  
             
        </td>
        
    </tr>
    <tr>
    	<td align="left" colspan="2">
        <b>Client:</b> <?=$open_row['owner_fName']?>&nbsp;<?=$open_row['owner_lName']?>        
        </td>
        
    </tr>
    <tr>
    	<td colspan="2">
        
        <label class="pull-left" for="deadline"><b>Deadline:</b></label> <input type="text" readonly="readonly" name="deadline" id="deadline" value="<?=$open_row['deadline']!="0000-00-00 00:00:00"?date("Y-m-d",strtotime($open_row['deadline'])):""?>" class="form-control span3" placeholder="No Deadline Set...">            			
        </td>
    </tr>
    <tr>
    	<td colspan="2" style="border-top:5px #000 solid"> 
        	
                    	<font size="+1"><b>Problem/Issue:</b></font>
                    	<br>
                        <textarea id="service_ticket_desc" class="form-control" <?php if(!$isAssigned){ ?>disabled="disabled" <?php } ?>><?=trim(stripslashes($open_row['service_ticket_desc']))?></textarea>
        </td>
    </tr>
    
    <tr>
    	<td colspan="2" style="border-top:5px #000 solid"> 
         
        	<table class="table table-condensed">
            	<tr>
                	<td bgcolor="#CCCCCC">
                    	<b>Tags:</b>
                    </td>                    
                </tr>
                <tr>	
                	<td>
                    	<?php 
						while($assign_row = mysqli_fetch_array($assign_res))
						{
							?>
                            <span class="label label-info"><span class="glyphicon glyphicon-user"></span> <?=getUserFullName($assign_row['username'])?> <a href="#" onclick="showIMForm('<?=$assign_row['username']?>'); return false;" style="color:#FFF"><span class="glyphicon glyphicon-comment"></span></a> <a href="#" onclick="removeAdmin('<?=$assign_row['username']?>')" style="color:#FFF"><span class="glyphicon glyphicon-remove"></span></a></span>
                            &nbsp;
                            <?php
						}
						if(mysqli_num_rows($assign_res) == 0)
						{
							echo "No One Assigned";
						}
						?>
                    </td>
                </tr>
                
            </table>
             
        </td>
    </tr>
    <tr>
    	<td colspan="2">
        <?php
            if(mysqli_num_rows($assign_res) > 0)
			{
			?>
        	<table class="table table-condensed">
            	<tr>
                	<td bgcolor="#CCCCCC">
                    <strong>Task:</strong>
                    </td>
                    <td align="right">
                    	<input type="input" id="current_task" placeholder="Enter your steps in solving this issue..." class="form-control"/>
                    </td>
                </tr>
                <tr>
                	
                    <td colspan="2">
                    	<table class="table table-condensed">
                        	<tr>
                            	<td height="42" valign="bottom" width="30px">
                                	<a href="#" class="btn btn-sm btn-default" onclick="moveTaskItem('up'); return false;"><span class="glyphicon glyphicon-circle-arrow-up"></span></a>
                                </td>
                                <td rowspan="2">
                                <div class="col-md-12">
                               	  <select id="task_list" size="5" class="form-control"></select>	
                                  </div>
                              </td>
                          </tr>
                            <tr>
                       	  <td valign="top">
                                	<a href="#" class="btn btn-sm btn-default" onclick="moveTaskItem('down'); return false;"><span class="glyphicon glyphicon-circle-arrow-down"></span></a>                                </td>
                                
                            </tr>
                        </table>
                    	
                    </td>
                </tr>
                <tr>
                	<td>
                    </td>
                	<td align="right">
                    	<a href="#" onclick="isEffective(); return false;" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-thumbs-up"></span> Worked</a> <a href="#" onclick="addTask(); return false;" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-plus"></span> Add Task</a> <a href="#" onclick="removeTask(); return false;" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-minus"></span> Remove Task</a>                    	
                    </td>
                </tr>
            </table>
            
            <?php
			}
			?>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
        <?php
            if(mysqli_num_rows($assign_res) > 0)
			{
				
			?>
        
        <table class="table table-condensed">
        	<tr>
            	<td>
                	<b>Notes:</b>&nbsp;<a href="#" class="btn btn-default btn-xs" onclick="prevNote(); return false;"><span class="glyphicon glyphicon-arrow-left"></span> Previous</a><a href="#" class="btn btn-default btn-xs" onclick="nextNote(); return false;"> Next <span class="glyphicon glyphicon-arrow-right"></span></a>
                </td>
                
            </tr>            
            <tr>
            	<td>
                	<div id="notes_view" style="height:100px; overflow:scroll; overflow-x:hidden"></div>
                </td>
            </tr>
            <tr>
            	<td valign="middle">
                <div class="col-md-2">
                	<img src="php/findDefaultProfileImg.php?username=<?=getCurrentUsername()?>&dim=40x40" class="img-circle img-retina">
                    </div>
                	<div class="input-group col-md-8 vertical-center">
                    	
                    	<a href="#" class="btn btn-info input-group-addon" onclick="addNote(); return false;"><span class="glyphicon glyphicon-comment"></span> Add Comment</a><input type="input" id="note_new" class="form-control" placeholder="Enter a comment here..."/>
                        </div>
                </td>
            </tr>
        </table> 
        <?php
		
			}
		?>
        </td>
    </tr><?     
	if($ticket_row['service_ticket_status'] == 1 || $ticket_row['service_ticket_status'] == 6)
	{  
	?>
   
   <tr>
   	<td bgcolor="#CCCCCC">
    	<strong>Job&nbsp;Status:</strong>
    </td>
    <td>
    	<?php
			open_db();
			$status_res = mysqli_query($db,"SELECT * FROM service_ticket_status_type_tab");
			close_db();
		 ?>
         <div class="input-group">
    	<select id="status_id" disabled="disabled" class="form-control">
        <?php 
		while($status_row = mysqli_fetch_array($status_res))
		{
			if($status_row['service_ticket_status_type_id'] == 1 && $status_row['service_ticket_status_type_id'] == 2){ continue; }
		?>
        <option value="<?=$status_row['service_ticket_status_type_id']?>" <?php if($status_row['service_ticket_status_type_id'] == $open_row['service_ticket_status']){ ?> selected="selected"<?php } ?> <?php if($status_row['service_ticket_status'] == 1){ ?> disabled="disabled"<? }?>><?=$status_row['service_ticket_status_type']?></option>
        <?php
		}
		?>
        </select>
        
        <?php
            if(!$isAssigned)
			{
			?>
			<span class="input-group-btn">
        	<button type="button" onclick="assignTicket(<?=$ticket_id?>,'<?=getCurrentUsername()?>')" <?php if($isAssigned){ ?> disabled="disabled"<?php } ?> class="btn btn-success"/>Take Ticket</button>
            </span>
            <?php }
			if($isAssigned)
			{
			?>
            <div class="btn-group input-group-btn">
                <button class="btn btn-warning dropdown-toggle" data-toggle="dropdown">Close Ticket <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a href="#" onclick="resolveTicket(<?=$ticket_id?>,'<?=getCurrentUsername()?>'); return false;"><i class="glyphicon glyphicon-ok" style="color:green"></i> Resolved</a></li>
                  <li><a href="#" onclick="rejectTicket(<?=$ticket_id?>,'<?=getCurrentUsername()?>'); return false;"><span class="glyphicon glyphicon-remove" style="color:red"></span> Rejected</a></li> 
                  <li><a href="#" onclick="unresolveTicket(<?=$ticket_id?>,'<?=getCurrentUsername()?>'); return false;"><i class="glyphicon glyphicon-trash"></i> Unresolved</a></li>                </ul>
              </div>
            </div> 
            <?php }  ?>
				
    </td>
   </tr>
   <tr>
   	<td bgcolor="#CCCCCC">
    	<strong>Assign&nbsp;Admin:</strong>
    </td>
    <td>
    	<?php 
			open_db();
			
			$assign_res1 = mysqli_query($db,"SELECT distinct ap.app_user_id FROM service_ticket_tab st,app_permission_tab ap 
										LEFT JOIN service_ticket_assignment_tab sta ON ap.app_user_id = sta.username
										WHERE ap.app_id = ".$_SESSION['app_id']." AND st.service_ticket_id = $ticket_id 
										AND ap.app_user_id NOT IN (SELECT username FROM service_ticket_assignment_tab WHERE service_ticket_id = st.service_ticket_id)");
			
			close_db();
		 ?>
         <div class="input-group">
   	  <select id="admin_list" <?php if($open_row['service_ticket_status'] == 2 || mysqli_num_rows($assign_res1) == 0){ ?> disabled="disabled"<?php } ?> class="form-control">
        <?php 
		
		if(mysqli_num_rows($assign_res1) == 0){ ?>
        <option>No One Left to Assign</option>
        
		<?php
			
			}
		while($assign_row1 = mysqli_fetch_array($assign_res1))
		{		
		?>
        <option value="<?=$assign_row1['app_user_id']?>"><i class="icon-user"></i> <?=getUserFullName($assign_row1['app_user_id'])?></option>
        <?php
		}
		?>
        </select>
        
        <?php
           
			if($isSupervisor)
			{
				?>
                <span class="input-group-btn">
					<button onclick="assignTicket(<?=$ticket_id?>,document.getElementById('admin_list').value); showPopup3('applications/service_ticket_admin/php/service_ticket_admin.issue.edit.php','ticket_id=<?=$ticket_id?>','getTasks();getNote(\'\')'); return false;" class="btn btn-default <?=($open_row['service_ticket_status'] == 2 || mysqli_num_rows($assign_res1) == 0)?"disabled":""?>">Tag</button>
                </span>
                <?php				
				}
			
			?>
            </div>
    </td>
   </tr>
   <?php }  ?>
    <tr>
    <td colspan="2"></td>
    </tr>
    <tr>
    	<td colspan="2" align="center">
        <a href="#" onclick="saveTicket();closePopup();return false;" class="btn btn-success btn-block btn-lg"><span class="glyphicon glyphicon-log-in"></span> Save</a>
        </td>
    </tr>
</table>
<style>
.datepicker{z-index:1151;}
</style>

