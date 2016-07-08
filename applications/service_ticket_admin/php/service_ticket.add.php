<?php
if(empty($_REQUEST['desc']))
{
	die("Please Type a Problem");
}
include("../../../php/vars.php");

$category = $_REQUEST['category'];
$desc = addslashes($_REQUEST['desc']);
$short_desc = addslashes($_REQUEST['short_desc']);
$owner = $_REQUEST['owner'];
$ip_address = $_SERVER['REMOTE_ADDR'];

$owner_fName = $_REQUEST['fName'];
$owner_lName = $_REQUEST['lName'];
$owner_tel = $_REQUEST['tel'];
$owner_email = $_REQUEST['email'].";".getCurrentUsername();
$deadline = $_REQUEST['deadline'];
$location = $_REQUEST['location'];

open_db();


$username = getCurrentUsername();
$dept = getUserDept($username);

$query = "INSERT INTO service_ticket_tab(service_ticket_type_id,service_ticket_desc,service_ticket_sdate,service_ticket_owner,service_ticket_owner_ip,service_ticket_status,added_by,owner_fName,owner_lName,owner_tel,owner_email,location,dept,short_desc) VALUES($category,'$desc','$today','$owner','$ip_address',1,'$username','$owner_fName','$owner_lName','$owner_tel','$owner_email',$location,'$dept','$short_desc')";


if(!mysqli_query($db,$query))
{
	echo "<p>Error Inserting Record</p>".mysqli_error($db)."<br>";
	
	
	?>
    <input type="hidden" id="isError" value="1"/>
    <?php
}
else
{
	$new_service_ticket_id = mysqli_insert_id($db);
	
	mysqli_query($db,"INSERT INTO service_ticket_log_tab(service_ticket_id,service_ticket_note,service_ticket_tech) VALUES($new_service_ticket_id,'New Service Ticket Created','$username')");
	
	$b_user = getLDAPUser(getCurrentUsername());
	
	if($owner != "")
	{
		addBlogEntry("Service Ticket was Created for You by <b>".getUserFullName(getCurrentUsername())."</b>",getCurrentUsername(),$owner);
	}
	if($deadline != '0000-00-00 00:00:00' || $deadline != '')
	{
		mysqli_query($db,"INSERT INTO service_ticket_deadlines(service_ticket_id,deadline) VALUES($new_service_ticket_id,'$deadline')");
	}
	
	 //pull more details on new ticket
	$category_res = mysqli_query($db,"SELECT sttt.service_ticket_type,l.`name` FROM service_ticket_tab stt, service_ticket_type_tab sttt,location l WHERE stt.service_ticket_type_id = sttt.service_ticket_type_id AND stt.location = l.ID AND stt.service_ticket_id = $new_service_ticket_id");
	$category_row = mysqli_fetch_array($category_res);
				
	$notice = addslashes("A New Service Ticket was opened by <b>".getUserFullName(getCurrentUsername())."</b> <a href=\"http://intranet/?app=service_ticket_admin&page=home\">Click Here</a> to view Tickets <br><br><b>Ticket Decription:</b> <br>".$desc."<br><br><b>Contact Details: </b><br><i>Name:</i> ".$owner_fName." ".$owner_lName."<br><i>Location:</i> ".addslashes($category_row['name'])."<br><i>Phone: </i> ".$owner_tel."<br><i>Email:</i> ".$owner_email);
	
/*	$app_user_res = mysqli_query($db,"SELECT app_user_id FROM app_permission_tab WHERE app_id = 11");
	
	while($app_user_row = mysqli_fetch_array($app_user_res))
	{
		$owners .= $app_user_row['app_user_id'].","; //insert owners in notification table as list delimited bt commas
	}
	$owners = trim($owners, ","); //remove excess commas*/
	
	if(!addNotification("New Service Ticket - # ".$new_service_ticket_id." (".$category_row['service_ticket_type']." - $short_desc)",$notice,11,$owner,0,1,$owner_email,NULL))
	{
		echo "<p>Notification Failed</p>";	
	}
	
	?>
	<input type="hidden" id="new_service_ticket_id" value="<?=$new_service_ticket_id?>"/>
    <input type="hidden" id="isError" value="0"/>
	<?php
}
close_db();
?>