<?php
@include("../../../php/vars.php");

open_db();
$res_res = mysqli_query($db,"SELECT * FROM service_ticket_tab where service_ticket_sdate != '0000-00-00 00:00:00' ");
close_db();

$count = 0;
$totalHours = 0;
while($res_row =  mysqli_fetch_array($res_res))
{
	if($row['service_ticket_cdate'] ==  "0000-00-00 00:00:00")
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

echo "<b>Average Ticket Time:</b>  ".round(($totalHours/$count),2)."  Hours";
?>