<?php
@include("../../../php/vars.php");
open_db();
$search_date = date("Y-m",strtotime($_REQUEST['search_date']));




$undel_res = mysqli_query($db,"SELECT DISTINCT(ap.app_user_id),(SELECT count(*) FROM service_ticket_tab st,service_ticket_assignment_tab sta 
WHERE st.service_ticket_cdate LIKE '$search_date%' AND st.service_ticket_id = sta.service_ticket_id AND sta.username = ap.app_user_id AND sta.username = ap.app_user_id) solved_count,(SELECT count(*) FROM service_ticket_tab st,service_ticket_assignment_tab sta 
WHERE st.service_ticket_cdate = '0000-00-00 00:00:00' AND st.service_ticket_id = sta.service_ticket_id AND sta.username = ap.app_user_id AND sta.username = ap.app_user_id AND st.service_ticket_status = 6) pending_count
FROM app_permission_tab ap
LEFT JOIN service_ticket_assignment_tab sta 
ON ap.app_user_id = sta.username
LEFT JOIN service_ticket_tab st 
ON sta.service_ticket_id = st.service_ticket_id
WHERE ap.app_id = 11");

$count_res =  mysqli_query($db,"SELECT * FROM service_ticket_tab WHERE service_ticket_sdate LIKE '$search_date%'");

close_db();

$print = $_REQUEST['print'];

if($print != 1)
{
?>

<?php } ?>
<table width="900px" cellpadding="3">
	<tr>
    	<td align="center" colspan="5">
        	<h1>Monthly Report (<?=date("F Y",strtotime($search_date))?>)</h1>
        </td>
    </tr>
    <tr>
    	<td colspan="5" align="left" style="border-bottom:2px #000 solid">
        	<b>Report ID:</b> <?=strtotime(date("Y-m-d H:m:s"))?> | <b>Date Generated:</b><?=date("M-Y")?> <input type="hidden" value="<?=$_REQUEST['page']?>" id="currentReport"><input type="hidden" value="<?=$search_date?>" id="report_date" /><input type="hidden" value="<?=$date_end?>" id="date_end" />
        </td>
    </tr>
    <?php
    if($print != 1)
{
?>
	
    <tr>
    	<td colspan="5" align="left">
        	<a href="#" class="btn btn-danger" onclick="printThis(); return false;"><i class="icon-print"></i> Print</a>
            <a href="?app=service_ticket_admin&page=report.monthly.date" class="btn btn-info">Select Date</a>
        	
        
        
	
        </td>
    </tr>
    <?php } ?>
    
    <tr>
    	<td colspan="4" style="font-size:18px">
        	<strong>Performance Report</strong>
        </td>
    </tr>
    <tr>
		<td colspan="4">
        	
    		<b>Total Issues Logged:</b> <?=mysqli_num_rows($count_res)?><br>
			<b>Total Administrators:</b> <?=mysqli_num_rows($undel_res)?>
    	</td>
	</tr>
    <tr style="font-weight:bold; border-bottom:2px #333 solid;">
    	
    	<td width="200">
        	Administrator </td>
       
        
        <td>
        	Issues Solved
        </td>
        <td>
        	Issues Pending
        </td>
        
    </tr>
<?php
$bgcolor = "#ffffff";


mysql_data_seek($undel_res,0);


while($undel_row = mysqli_fetch_array($undel_res,MYSQL_ASSOC))
{
	if($bgcolor == "#ffffff")
	{
		$bgcolor = "#CCCCCC";	
	}
	else
	{
		$bgcolor = "#ffffff";
	}
?>
	<tr height="30" bgcolor="<?=$bgcolor?>">
    	
    	<td>
        	<?=getUserFullName($undel_row['app_user_id'])?>
        </td>
        
       
        <td>
            
        	<?=$undel_row['solved_count']?>
        </td>
        <td>
        	<?=$undel_row['pending_count']?>
        </td>
        
    </tr>
<?php	
}
?>
<tr>
	<td colspan="5" style="border-top:2px #000 solid" align="center">
    	End of Top Recipients List Report
    </td>
</tr>
<tr>
	<td colspan="5">
    	<b>Total Issues Logged:</b> <?=mysqli_num_rows($count_res)?><br>
			<b>Total Administrators:</b> <?=mysqli_num_rows($undel_res)?>
    </td>
</tr>
</table>

<?php
if($_REQUEST['print'] == 1)
{
	?>
<script>
		window.print();
	</script>
    <?php	
}
?>