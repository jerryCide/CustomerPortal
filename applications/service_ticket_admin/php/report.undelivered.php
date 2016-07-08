<?php
@include("../../../php/vars.php");
open_db();
$search_date = $_REQUEST['search_date'];
$month = date("m",strtotime($search_date));
$year = date("Y",strtotime($search_date));
$day = date("d",strtotime($search_date));

$undel_res = mysqli_query($db,"SELECT * FROM mail_corr_incoming WHERE deliver_date = '0000-00-00 00:00:00' AND month(date_recv) = $month AND year(date_recv) = $year AND day(date_recv) = $day");
close_db();

if(mysqli_num_rows($undel_res ) == 0)
{
	?>
    <script>
		alert("No Report for that date");
		window.location = '?app=mailCor&page=report.date';
	</script>
    <?php	
}

$print = $_REQUEST['print'];

if($print != 1)
{
?>
<table id="Table_01" height="40" border="0" cellpadding="0" cellspacing="0" style="cursor:pointer; font-family:Geneva, Arial, Helvetica, sans-serif" onClick="window.location='index.php?app=mailCor&page=reports'">
	<tr>
		<td width="9" height="9" background="/images/button_01.jpg"></td>
		<td background="/images/button_02.jpg" height="9"></td>
		<td background="/images/button_03.jpg" width="9" height="9"></td>
	</tr>
	<tr>
		<td background="/images/button_04.jpg" width="9" height="22"></td>
		<td background="/images/button_05.jpg" height="22" valign="middle" align="center" style="font-weight:bold">Back To Reports</td>
		<td background="/images/button_06.jpg" width="9" height="22"></td>
	</tr>
	<tr>
		<td background="/images/button_07.jpg" width="9" height="9"></td>
		<td background="/images/button_08.jpg" height="9"></td>
		<td background="/images/button_09.png" width="9" height="9"></td>
	</tr>
</table>
<?php } ?>
<table width="100%" cellpadding="3">
	<tr>
    	<td align="center" colspan="5">
        	<h1>Mail Distribution List (<?=date("d-M-Y",strtotime($search_date))?>)</h1>
        </td>
    </tr>
    <tr>
    	<td colspan="5" align="left" style="border-bottom:2px #000 solid">
        	<b>Report ID:</b> <?=strtotime(date("Y-m-d H:m:s"))?> | <b>Date Generated:</b><?=date("d-M-Y")?> <input type="hidden" value="<?=$_REQUEST['page']?>" id="currentReport"><input type="hidden" value="<?=$search_date?>" id="report_date" /><input type="hidden" value="" id="date_end" />
        </td>
    </tr>
    <?php
    if($print != 1)
{
?>
	
    <tr>
    	<td colspan="5" align="left">
        <table>
        	<tr>
            	<td>
                	<table id="Table_01" height="40" border="0" cellpadding="0" cellspacing="0" style="cursor:pointer; font-family:Geneva, Arial, Helvetica, sans-serif" onClick="printThis(); return false;">
	<tr>
		<td width="9" height="9" background="/images/button_01.jpg"></td>
		<td background="/images/button_02.jpg" height="9"></td>
		<td background="/images/button_03.jpg" width="9" height="9"></td>
	</tr>
	<tr>
		<td background="/images/button_04.jpg" width="9" height="22"></td>
		<td background="/images/button_05.jpg" height="22" valign="middle" align="center" style="font-weight:bold">Print</td>
		<td background="/images/button_06.jpg" width="9" height="22"></td>
	</tr>
	<tr>
		<td background="/images/button_07.jpg" width="9" height="9"></td>
		<td background="/images/button_08.jpg" height="9"></td>
		<td background="/images/button_09.png" width="9" height="9"></td>
	</tr>
</table>
                </td>
                <td>
                	<table id="Table_01" height="40" border="0" cellpadding="0" cellspacing="0" style="cursor:pointer; font-family:Geneva, Arial, Helvetica, sans-serif" onClick="window.location='index.php?app=mailCor&page=report.date'">
	<tr>
		<td width="9" height="9" background="/images/button_01.jpg"></td>
		<td background="/images/button_02.jpg" height="9"></td>
		<td background="/images/button_03.jpg" width="9" height="9"></td>
	</tr>
	<tr>
		<td background="/images/button_04.jpg" width="9" height="22"></td>
		<td background="/images/button_05.jpg" height="22" valign="middle" align="center" style="font-weight:bold">Select Date</td>
		<td background="/images/button_06.jpg" width="9" height="22"></td>
	</tr>
	<tr>
		<td background="/images/button_07.jpg" width="9" height="9"></td>
		<td background="/images/button_08.jpg" height="9"></td>
		<td background="/images/button_09.png" width="9" height="9"></td>
	</tr>
</table>
                </td>
            </tr>
        </table>
        
        
	
        </td>
    </tr>
    <?php } ?>
    <tr style="font-weight:bold; border-bottom:2px #333 solid;">
    	<td width="55">
        	From
        </td>
    	<td width="100">
        	To</td>
        <td  width="100">
        	Subject</td>
        <td width="100">
        	Recv'd Date
        </td>
        <td>
        	Signature
        </td>
    </tr>
<?php
$bgcolor = "#ffffff";
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
        	<?=substr($undel_row['sender'],0,20)?>
        </td>
    	<td>
        	<?=$undel_row['recv']?>
        </td>
        <td>
        	<?=substr($undel_row['subject'],0,20)?>
        </td>
        <td>
        	<?=date("d-M-Y",strtotime($undel_row['date_recv']))?>	
        </td>
        <td style="border-bottom:1px #000 dotted">&nbsp;
        	
        </td>
    </tr>
<?php	
}
?>
<tr>
	<td colspan="5" style="border-top:2px #000 solid" align="center">
    	End of Report Dated: <?=date("d-M-Y",strtotime($search_date))?>
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