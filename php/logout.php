<?php
include("vars.php");
session_start();
$session_user = unserialize($_SESSION['USER']);
echo "<b>".$session_user->username."</b> Logged Out";
unset($_SESSION['USER']);
$ip = $_SERVER['REMOTE_ADDR'];
open_db(); 
mysqli_query($db,"DELETE FROM registry WHERE ip_address = '$ip'");
close_db();


?>