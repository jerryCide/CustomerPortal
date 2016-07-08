<?php
include("vars.php");

open_db();

$download_res = mysqli_query($db,"SELECT D.download_id FROM download_permission_tab DP, download_tab D 
WHERE D.download_id = DP.download_id AND (DP.username = '' OR DP.username = '".getCurrentUsername()."') AND D.active = 1 ORDER BY date_added DESC LIMIT 0,5");

close_db();
$download_list = "";

while($download_row = mysqli_fetch_array($download_res))
{
	
	$download_list .= $download_row['download_id'].",";
}

$download_list = rtrim($download_list,",");
?>

<input type="hidden" id="download_list_new" value="<?=$download_list?>">