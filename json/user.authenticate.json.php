<?php
include("../php/vars.php");

if(empty($_REQUEST['username']))exit;

$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

$data = array();

if(checkLDAPLogin($username,$password))
{
	array_push($data,array("isCorrect"=> 1,"server_time" => time()));	
}
else
{
	array_push($data,array("isCorrect"=> 0,"server_time" => time()));	
}

echo json_encode($data); //encode output to json for consumption
?>