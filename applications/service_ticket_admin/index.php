<script type="text/javascript" src="applications/service_ticket_admin/javascript/ajax_funcs.js"></script>
<?php
open_db();
$username = getCurrentUsername();
/*$assign_ticket_res = mysqli_query($db,"SELECT count(*) as assign_count FROM service_ticket_assignment_tab stst, service_ticket_tab stt 
WHERE stst.service_ticket_id = stt.service_ticket_id AND (stt.service_ticket_status = 6 OR stt.service_ticket_status = 1) AND stst.username = '$username'");

$unassign_ticket_res = mysqli_query($db,"SELECT count(*) as unassign_count FROM service_ticket_tab stt 
WHERE stt.service_ticket_status = 1");*/

$action_ticket_res = mysqli_query($db,"SELECT count(*) as action_count FROM service_ticket_tab stt 
WHERE (stt.service_ticket_status = 1 OR stt.service_ticket_status = 6) AND (stt.service_ticket_id IN (SELECT service_ticket_id FROM service_ticket_deadlines WHERE deadline != '0000-00-00 00:00:00'))");

$assign_ticket_row = mysqli_fetch_array($assign_ticket_res);
$unassign_ticket_row = mysqli_fetch_array($unassign_ticket_res);
$action_ticket_row = mysqli_fetch_array($action_ticket_res);
?>
<center>
<div class="well">
<a href="?app=service_ticket_admin&page=home" class="btn btn-info <?=$_REQUEST['page']=="home"?"active":""?>" id="assigned_nav"><img src="images/site_icons/home_16.png" > Home - My Tickets <span id="countAssignDiv" class="badge badge-inverse">-</span></a>

<a href="?app=service_ticket_admin&page=service_ticket_admin.issues.active" class="btn btn-info <?=$_REQUEST['page']=="service_ticket_admin.issues.active"?"active":""?>" id="assigned_nav"><img src="images/site_icons/home_16.png" > Active Tickets <span id="countAssignDiv" class="badge badge-inverse">-</span></a>

<a href="?app=service_ticket_admin&page=service_ticket_admin.actionItems" class="btn btn-info <?=$_REQUEST['page']=="service_ticket_admin.actionItems"?"active":""?>" id="action_nav"><img src="images/site_icons/time.gif"> Action Sheet <span class="badge badge-inverse"><?=$action_ticket_row['action_count']?></span></a>

<a href="?app=service_ticket_admin&page=service_ticket_admin.issues.unassigned" class="btn btn-info <?=$_REQUEST['page']=="service_ticket_admin.issues.unassigned"?"active":""?>" id="unassigned_nav"><img src="images/site_icons/People_034.gif"> Unassigned Tickets <span id="countUnassignDiv" class="badge badge-inverse">-</span></a>

<a href="?app=service_ticket_admin&page=service_ticket_admin.issues&status_id=6" class="btn btn-info <?=$_REQUEST['page']=="service_ticket_admin.issues"?"active":""?>"><img src="images/site_icons/search.gif"> Tickets Search</a>

<a href="?app=service_ticket_admin&page=reports" class="btn btn-info <?=$_REQUEST['page']=="reports"?"active":""?>"><img src="images/site_icons/report.png"> Reports</a>

<a href="?app=service_ticket_admin&page=service_ticket.new" class="btn btn-info <?=$_REQUEST['page']=="service_ticket.new"?"active":""?>"><img src="images/site_icons/plus_16.png"> Start New Ticket</a>
</div>



<div>
        <?php
	if(empty($_REQUEST['page']))
	{
		include("applications/service_ticket_admin/php/home.php");
	}
	
	$page = $_REQUEST['page']; 
	$file = "applications/service_ticket_admin/php/$page.php";
	
	if(isset($page))
	{
		if(!(@include($file)))
		{
			echo $page . " does not exist";	
		}
	}	
?>

</div>

<div id="st_system_msg"></div>
<div id="count_results"></div>
<div id="debug_div"></div>
</center>
<script>
setInterval("getAssignedCount()",5000)
setInterval("getUnassignedCount()",5100)
getUnassignedCount()
getAssignedCount()


</script>