<?php

if(empty($_REQUEST['service_ticket_id']))
{
	die("No Service Ticket ID");
}

include("../../../php/vars.php");
open_db();


$service_ticket_id = $_REQUEST['service_ticket_id'];
$username = getCurrentUsername();
$note = addslashes($_REQUEST['note']);

if(!mysqli_query($db,"INSERT INTO service_ticket_note_tab(service_ticket_id,note,`from`) VALUES($service_ticket_id,'$note','$username')"))
{
	
?>
	<input type="hidden" value="1" id="isError">
    <input type="hidden" value="Adding Note Failed" id="errorMessage">
<?php	
}
else
{
	
	//pull more details on new ticket
		$category_res = mysqli_query($db,"SELECT sttt.service_ticket_type,l.`name`,stt.owner_fName,stt.owner_lName,stt.owner_tel,stt.owner_email,stt.service_ticket_desc,stt.short_desc 
										FROM service_ticket_tab stt, service_ticket_type_tab sttt,location l WHERE stt.service_ticket_type_id = sttt.service_ticket_type_id AND stt.location = l.ID AND stt.service_ticket_id = $service_ticket_id");
		$category_row = mysqli_fetch_array($category_res);
				
		$notice = "<b>".getUserFullName(getCurrentUsername())."</b> posted note to Service Ticket - # $service_ticket_id <br><br><b>".getUserFullName(getCurrentUsername())." Wrote:</b> <br>".$note."<br><br><b>Ticket Details: </b><br>".$category_row['service_ticket_desc'];
		
		$app_user_res = mysqli_query($db,"SELECT `username` FROM service_ticket_assignment_tab WHERE service_ticket_id = $service_ticket_id");
	
		while($app_user_row = mysqli_fetch_array($app_user_res))
		{
			$owners .= $app_user_row['username'].","; //insert owners in notification table as list delimited bt commas
		}
		$owners = trim($owners, ","); //remove excess commas
		
		//add notification for person assigned to ticket
		if(!addNotification("Administrator Posted Note to Ticket  - # ".$service_ticket_id." (".$category_row['service_ticket_type']." - ".$category_row['short_desc'].")",$notice,11,$owners,0,1,$category_row['owner_email'],NULL))
		{
			?>
            <input type="hidden" value="1" id="isError">
            <input type="hidden" value="Adding Notification Failed" id="errorMessage">
            <?php	
		}
		else
		{
		?>
            <input type="hidden" value="0" id="isError">
            <input type="hidden" value="Notification Added Successfully" id="errorMessage">
            <?php	
		}
?>
	<input type="hidden" value="0" id="isError">
    <input type="hidden" value="Note Added Successfully" id="errorMessage">
<?php	
	
}

close_db();

?>