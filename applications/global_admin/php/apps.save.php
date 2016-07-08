<?php
include("../../../php/vars.php");
$app_name = $_REQUEST['app_name'];
$app_id = $_REQUEST['app_id'];
$app_dir = $_REQUEST['app_dir'];
$app_isonline = $_REQUEST['app_isonline'];
$app_isPrivate = $_REQUEST['app_isprivate'];

open_db();
if(!mysqli_query($db,"UPDATE app_tab SET app_name = '$app_name', app_dir = '$app_dir', app_isonline = $app_isonline, app_isPrivate = $app_isPrivate WHERE app_id = $app_id"))
{
	echo "Error Saving Application Profile<br>";
	?>
    <input type="hidden" id="isError" value="1" />
    <?php
}
else
{
	echo "Updated Successfully";
	?>
    <input type="hidden" id="isError" value="0" />
    <?php
}
close_db();

?>