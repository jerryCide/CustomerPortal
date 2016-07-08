<?php
if(empty($_REQUEST['service_ticket_id']))
{
	die("No Service Ticket ID Provided");	
}


$note_id = $_REQUEST['note_id'];
$service_ticket_id = $_REQUEST['service_ticket_id'];

include("../../../php/vars.php");
open_db();

$position = 1;

$all_res = mysqli_query($db,"SELECT ID FROM service_ticket_note_tab WHERE service_ticket_id = $service_ticket_id");

if(mysqli_num_rows($all_res) == 0)
{
	die ("<center><b>No Notes Found, please add notes below</b></center>");	
}

while($all_row = mysqli_fetch_array($all_res))
{
	if($all_row['ID'] < $note_id)
	{
		$position++;	
	}
	?>
    <input type="hidden" name="note_id_nums" size="1" value="<?=$all_row['ID']?>">
    <?php	
}
$all_count = mysqli_num_rows($all_res);

if(empty($_REQUEST['note_id']))
{
	$res = mysqli_query($db,"SELECT * FROM service_ticket_note_tab WHERE service_ticket_id = $service_ticket_id ORDER BY ID DESC LIMIT 1");
	$position = $all_count;
	
}
else
{
	$note_id = $_REQUEST['note_id'];
	$res = mysqli_query($db,"SELECT * FROM service_ticket_note_tab WHERE ID = $note_id");
}

close_db();

$row = mysqli_fetch_array($res);
?>

<table width="100%">
	<tr>
    	<td>
        <b>From:</b><i class="icon-user"></i> <i><b><?=getUserFullName($row['from'])?></b></i>&nbsp;<i class="icon-time"></i><?=date("F d, Y g:i A",strtotime($row['date_added']))?>
        </td>
    </tr>
    <tr>
    	<td>
        	<?=$row['note']?>
        </td>
    </tr>
    <tr>
    	<td align="center">
        	<?=$position?> <b>OF</b> <?=$all_count?>
        </td>
    </tr>
</table>

<input type="hidden" id="last" value="<?=$last?>">
<input type="hidden" id="current" value="<?=$row['ID']?>">