<?php
include("../php/vars.php");

$img_id = $_REQUEST['img_id'];

open_db();
if( mysqli_query($db,"DELETE FROM news_img_tab WHERE img_id = $img_id"))
{
 echo "Image was deleted Successfully";
}
else
{
 echo "Deletion Failed";
}
close_db();
?>