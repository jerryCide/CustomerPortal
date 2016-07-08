<?php
include("../../../php/vars.php");
open_db();
$res = mysqli_query($db,"SELECT count(incoming_id) as mail_count,recv FROM mail_corr_incoming GROUP BY recv ORDER BY mail_count DESC");
close_db();
$total = 0;
$usernames = NULL;
$chd = "";
$values = NULL;

while($row = mysqli_fetch_array($res,MYSQL_ASSOC))
{
	$usernames [] = $row['recv'];
	$values[] = $row['mail_count'];
	
}

?>



