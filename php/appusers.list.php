<?php
include("vars.php");
$app_dir = $_REQUEST['app_dir'];

open_db();
$app_res = mysqli_query($db,"SELECT * FROM app_tab WHERE app_dir = '$app_dir'");
$app_row = mysqli_fetch_array($app_res);
$app_id = $app_row['app_id'];
$online_res = mysqli_query($db,"SELECT * FROM app_permission_tab as apt, session_tab as st WHERE app_id = $app_id AND apt.app_user_id = username");
close_db();
?>

<b>Using this App:</b>
<?php 
	while($online_row = mysqli_fetch_array($online_res,MYSQL_ASSOC))
	{
					?>
    	<img src="findDefaultProfileImg.php?username=<?=$online_row['username']?>&dim=50x50" width="50" style="border:1px solid #ccc"/>&nbsp;
                    <?php 
	}
?>