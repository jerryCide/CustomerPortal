<?php
include("../../../php/vars.php");
open_db();
$res = mysqli_query($db,"SELECT count(incoming_id) as mail_count,recv FROM mail_corr_incoming GROUP BY recv ORDER BY mail_count DESC");
close_db();
$total = 0;
$chl = "";
$chd = "";
$count_array = NULL;

while($row = mysqli_fetch_array($res,MYSQL_ASSOC))
{
	$chl .= $row['recv']."|";
	$count_array[] = $row['mail_count'];
	$total = $total + $row['mail_count'];
}

foreach($count_array as $value)
{
	$percentages[] = round(($value/$total)*100,2);
	
}

$chd = implode(",",$percentages);


?>

<img src="http://chart.apis.google.com/chart?cht=p3&chd=t:<?=$chd?>&chs=600x300&chl=<?=$chl?>" width="600" height="300">

