<?php
//get current user logged in and assign ticket to user

include("../../../php/vars.php");
if(getCurrentUsername() == "")
{
	die("No Session Active");
}

if(!empty($_REQUEST['assign_user']))
{
	$current_user = $_REQUEST['assign_user'];	
}
else
{
	$current_user = getCurrentUsername();	
}

$service_ticket_id = $_REQUEST['service_ticket_id'];

open_db();
//check to see if user is already assigned
$check_res = mysqli_query($db,"SELECT * FROM service_ticket_assignment_tab WHERE service_ticket_id = $service_ticket_id AND username = '$current_user'");

$isError = 0;
$errorMsg = "";
if(mysqli_num_rows($check_res) == 0) //username not assigned, therefore assign
{
	if(!mysqli_query($db,"UPDATE service_ticket_tab SET service_ticket_status = 6 WHERE service_ticket_id = $service_ticket_id")) //update ticket to assigned
	{ 
		$errorMsg .= "Update of Ticket Status Failed, Contact Administrator. ";
		$isError = 1; 
	}
	
	
	if(!mysqli_query($db,"INSERT INTO service_ticket_assignment_tab(service_ticket_id,username) VALUES($service_ticket_id,'$current_user')"))
	{ 
		$isError = 1; 
		$errorMsg .= "Tagged Insert Failed for $current_user and Ticket#: $service_ticket_id, Contact Administrator.<br>";
	}
	else
	{
		mysqli_query($db,"INSERT INTO service_ticket_log_tab(service_ticket_id,service_ticket_note,service_ticket_tech) VALUES($service_ticket_id,'$current_user was Tagged in to Ticket','".getCurrentUsername()."')"); 
		//pull more details on new ticket
		$category_res = mysqli_query($db,"SELECT sttt.service_ticket_type,l.`name`,stt.owner_fName,stt.owner_lName,stt.owner_tel,stt.owner_email,stt.service_ticket_desc FROM service_ticket_tab stt, service_ticket_type_tab sttt,location l WHERE stt.service_ticket_type_id = sttt.service_ticket_type_id AND stt.location = l.ID AND stt.service_ticket_id = $service_ticket_id");
		$category_row = mysqli_fetch_array($category_res);
				
		$notice = addslashes("<b>".getUserFullName($current_user)."</b> was Tagged into Service Ticket - # $service_ticket_id by <b>".getUserFullName(getCurrentUsername())."</b> <br><br><b>Ticket Decription:</b> <br>".$category_row['service_ticket_desc']."<br><br><b>Contact Details: </b><br><i>Name:</i> ".$category_row['owner_fName']." ".$category_row['owner_lName']."<br> <i>Location:</i> ".addslashes($category_row['name'])."<br><i>Phone:</i> ".$category_row['owner_tel']."<br><i>Email:</i> ".$category_row['owner_email']);
		
		//add notification for person assigned to ticket
		if(!addNotification("Administrator Tagged in to Ticket  - # ".$service_ticket_id." (".$category_row['service_ticket_type'].")",$notice,11,$current_user,0,1,$category_row['owner_email'],NULL))
		{
			$isError = 1;
			$errorMsg .= "Notification Failed. ";			
		}	
	}	
}
close_db();

?>
<input type="hidden" id="isError" value="<?=$isError?>" />
<input type="hidden" id="errorDesc" value="<?=mysql_error()." ".$errorMsg?>">