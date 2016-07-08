<?php
@include("../../../php/vars.php");
open_db();
$undel_res = mysqli_query($db,"SELECT *,
(SELECT max(deadline) FROM service_ticket_deadlines WHERE service_ticket_id = st.service_ticket_id) deadline 
FROM service_ticket_tab st,service_ticket_status_type_tab stst
WHERE (service_ticket_status = 1 OR service_ticket_status = 6) AND stst.service_ticket_status_type_id  = st.service_ticket_status");

if($_REQUEST['print'] == 1)
{
	?>
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css" />
    <script type="text/javascript" src="/js/bootstrap.js"></script>
    <style>
		table
		{
			font-size:9px;
			}
	</style>
    <?php
	}

?>

<table width="100%" cellpadding="7" class="table table-striped">
	<tr>
    	<td align="center" colspan="7">
        	<h1>UnResolved Tickets</h1>
        </td>
    </tr>
    <tr>
    	<td colspan="7" align="left">
        	<b>Report ID:</b> <?=strtotime(date("Y-m-d H:m:s"))?> | <b>Date Generated:</b> <?=date("d-M-Y")?> <input type="hidden" value="<?=$_REQUEST['page']?>" id="currentReport"><input type="hidden" value="" id="report_date"><input type="hidden" value="" id="date_end"> 
        </td>
    </tr>
    <tr>
    	<td colspan="7" align="left">
        	<a href="#!" onClick="printThis(); return false;" class="btn"><i class="icon-print"></i> PRINT</a>
        </td>
    </tr>
    <tr style="font-weight:bold; border-bottom:2px #333 solid;">
    	<td width="80">
        	Ticket ID
        </td>
    	<td width="100">
        	Ticket Type
        </td>
        <td  width="150">
        	Date Added
        </td>
        <td>
        	Status
        </td>
        <td>
        	Assignee(s)
        </td>
        <td>
        	Deadline
        </td>
        <td>
        	Overdue/Due
        </td>
    </tr>
<?php
$bgcolor = "#ffffff";
while($undel_row = mysqli_fetch_array($undel_res,MYSQL_ASSOC))
{
	$assign_res = mysqli_query($db,"SELECT username FROM service_ticket_assignment_tab WHERE service_ticket_id = ".$undel_row['service_ticket_id']);
		
?>
	<tr height="30">
    	<td>
        	<?=$undel_row['service_ticket_id']?>            
            
        </td>
    	<td>
        	<?=$undel_row['service_ticket_status_type']?>
        </td>
        <td>
        	<?=$undel_row['service_ticket_sdate']?>
        </td>
        <td>
        	<?=$undel_row['service_ticket_status_type']?>	
        </td>
        <td>
        	<ul>
        	<?php
			while($assign_row = mysqli_fetch_array($assign_res,MYSQL_ASSOC))
			{
				echo "<li><i class=\"icon-user\"></i> ".getUserFullName($assign_row['username'])."</li>";	
			}
            
			?>
            </ul>
        </td>
        <td>
        	<?
			
        	if($undel_row['deadline'] != "" && $undel_row['deadline'] != "0000-00-00 00:00:00")
			{
			?>
        	<?=date("M d, Y",strtotime($undel_row['deadline']))?>
            <? } 
			else
			{
				echo "NONE";
				}
			?>
        </td>
        <td width="400">
        <?
        	if($undel_row['deadline'] != ""){
			?>
        <?php
        	$date_diff_array = date_diff2(strtotime($undel_row['deadline']),strtotime($today));
			?>
            <b>days:</b> <?=$date_diff_array['day']?>  <b>hours:</b> <?=$date_diff_array['hour']?>
            <? } 
			else
			{
				echo "N/A";
				}
			?>
        </td>
    </tr>
<?php	
}
close_db();
?>
</table>

<script>
function doPrint()
{
	window.print();	
}
</script>

<?php
if($_REQUEST['print'] == 1)
{
	?>
    <script>
		doPrint()
	</script>
    
    <?php } ?>
	