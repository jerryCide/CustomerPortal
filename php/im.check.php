<?php
include("vars.php");

@session_start();
if(empty($_SESSION['USER']))
{
	die("User Not Logged In");	
}
$username = getCurrentUsername();
open_db();
$im_res = mysqli_query($db,"SELECT * FROM im_tab WHERE recvr = '$username' AND date_recv = '00-00-0000 00:00:00' AND isread = 0 ORDER BY date_sent ASC LIMIT 0,1");


close_db();

if(mysqli_num_rows($im_res) == 0)
{
	?>
	<input type="hidden" value="0" id="isNewIM">
	<?php		
}
else
{
	$row = mysqli_fetch_array($im_res);
	
	open_db();
	if(!mysqli_query($db,"UPDATE im_tab SET date_recv = '$today' WHERE im_id = ".$row['im_id']))
	{
		echo "Error Updating IM record<br>".mysql_error();
	}
	else
	{
		echo "Updated Successfully";	
	}
	//echo "UPDATE im_tab SET date_recv = '$today' WHERE im_id = ".$row['im_id'];
	?>
    <input type="hidden" value="<?=$row['im_id']?>" id="isNewIM">
    
    <?php	
	close_db();
}
?>