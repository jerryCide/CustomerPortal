<?php

$status_id = 6;		
$username = getCurrentUsername();

include("../../../php/vars.php");
open_db();

$query = "SELECT * FROM service_ticket_tab stt, service_ticket_status_type_tab sts, service_ticket_assignment_tab sta WHERE stt.service_ticket_status = $status_id AND stt.service_ticket_status = sts.service_ticket_status_type_id  AND sta.service_ticket_id = stt.service_ticket_id AND sta.username = '$username'";

$open_res = mysqli_query($db,$query);

close_db();
?>

<table width="890px">
	<tr>
    	<td>
         	<h1>My Assigned Tickets</h1>
        </td>
    </tr>
    <tr>
    	<td>
        	
        </td>
    </tr>
    <tr>
    	<td>
        	
        	<?php
			
			if(mysqli_num_rows($open_res) == 0)
			{?>            
				<h2>No Tickets Assigned To You</h2>	
                <?php
			}
            while($open_row = mysqli_fetch_array($open_res,MYSQL_ASSOC))
			{
				?>
                <table width="100%" bgcolor="#DDDDDD" style="border:1px #999 solid" class="<?php if($open_row['service_ticket_status'] == 6){ echo "assigned"; }else if($open_row['service_ticket_status'] > 1 && $open_row['service_ticket_status'] < 6){ echo "closed"; } ?>">
                <tr>
                	<td width="91%" valign="top">
                    <div>
                    	<div style="float:left;width:50px"><img src="php/findDefaultProfileImg.php?username=<?=$open_row['service_ticket_owner']?>&dim=50x50" width="50" class="profilePhoto"/></div>
                        <div style="float:left">
                        <b><font size="+1"><?=$open_row['service_ticket_desc']?></font></b><br> 
                        <b>Client Username:</b> <?=empty($open_row['service_ticket_owner'])?"[Not Provided]": $open_row['service_ticket_owner']?><br>
                        <b>Client Name:</b> <?=$open_row['owner_fName']?> <?=$open_row['owner_lName']?><br>
                        <?php $b_user = getLDAPUser($open_row['added_by']); ?>
                        <b>Added By: </b> <?=$b_user['fullName']?>
                        </div>
                        </div>
                    </td>
                    <td width="9%" align="right">
                    	<b>Status:</b> <?=$open_row['service_ticket_status_type']?>
                    </td>
                </tr>
                <tr>
                	<td>
                    	<font color="#666666"><?=$open_row['service_ticket_desc']?></font>
                    </td>
                    <td align="right">
                    	<input type="button" value="View/Edit" onclick="showPopup3('/applications/service_ticket_admin/php/service_ticket_admin.issue.edit.php','ticket_id=<?=$open_row['service_ticket_id']?>','getTasks();getNote(\'\')'); " class="btn"/>
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