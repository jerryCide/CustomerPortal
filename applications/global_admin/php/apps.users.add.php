<?php
include("../../../php/vars.php");
$username = strtolower($_REQUEST['username']);
$app_id = $_REQUEST['app_id'];
$isSupervisor = $_REQUEST['isSupervisor'];
$app_name = $_REQUEST['app_name'];



if(!isUserValid($username))
{
	die("User is invalid");
}

open_db();


$res = mysqli_query($db,"SELECT * FROM app_permission_tab WHERE app_id = $app_id AND lower(app_user_id) = '$username'");

if(mysqli_num_rows($res) > 0)
{
	die("User Already Exists");
}

if(!mysqli_query($db,"INSERT INTO app_permission_tab(app_id,app_user_id,isSupervisor) VALUES($app_id,'$username',$isSupervisor)"))
{
	echo "Failed to Add user";
}

$subject = "Access given to $main_title Intranet application";
$message = "You have been added to Intranet Application: <b>$app_name</b>, login to <a href=\"http://intranet\">MWH Intranet</a> view applications to see application you have been added to";
					
addNotification($subject,$message,$app_id,$username,0,1,"",NULL);
close_db();
?>