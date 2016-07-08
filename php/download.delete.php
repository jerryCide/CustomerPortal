<?php
if(empty($_REQUEST['download_id']))
{
	die('No File Selected');	
}

$download_id = $_REQUEST['download_id'];

include("vars.php");
open_db();
$file_res = mysqli_query($db,"SELECT * FROM download_tab WHERE download_id = $download_id");
$file_row = mysqli_fetch_array($file_res);

mysqli_query($db,"UPDATE download_tab SET active = 0 WHERE download_id = $download_id");
close_db();

$fileName = $file_row['location'];

unlink("../".$fileName);
?>