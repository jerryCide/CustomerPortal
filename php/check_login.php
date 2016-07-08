<?php
if(empty($_REQUEST['username_login']))exit;
@session_start();
unset($_SESSION['USER']);

@include("vars.php");
error_reporting(0); 
$response = array();

/*$pingresult = exec("ping $ldap_server_ip", $outcome, $status);
echo "$ldap_server_ip :".$status;

foreach($outcome as $key => $value)
{
	echo "<p>".$key." => ".$value."</p>";	
}
  
  exit;
if($pingresult != 0)
{
	$response['error_msg_title'] = "Error Logging in";
	$response['error_msg'] =  "Cannot find LDAP Server";
	$response['isError'] = 1;
	$response['authenticate']  =  0;
	exit;	
}*/

$username = $_REQUEST['username_login'];
$password = $_REQUEST['password'];
$ip = $_SERVER['REMOTE_ADDR'];


checkExternalLogin($username,$password);

if(!isUserSessionSet())
{
 	open_db();
	log_event('Login Failed:','error',$username);
 	close_db();	
		
	$response['error_msg_title'] = "Error Logging in";
	$response['error_msg'] =  "Username and Password combination failed, Try Again";
	$response['isError'] = 1;
	$response['authenticate']  =  0;	
}
else
{
	$response['isPasswordReset'] = $isPasswordReset;
	$response['info_msg'] = "Username was flagged for Password Reset";
	$response['info_msg_title'] = "Password Reset";
	$response['isError'] = 0;
	$response['info_msg'] = "Log In Successful";
	$response['info_msg_title'] = "Access Granted";
	$response['authenticate'] = 1;
		
	$session_id = session_id();
 	$session_string = session_encode();
 	open_db();
	
	$session_res = mysqli_query($db,"SELECT * FROM system_session_tab WHERE username = '$username'");
	$session_row = mysqli_fetch_array($session_res);
	
	if($session_row['system_time'] < $today)
	{
	 if(!mysqli_query($db,"DELETE FROM system_session_tab WHERE username = '$username'"))
	 {
	  	//echo "Error: Cannot Delete Session";
	 }
	}
	if(!mysqli_query($db,"INSERT INTO system_session_tab VALUES('$session_id','$username','$session_string','$today','')"))
	{
		if(mysqli_errno($db)=="1062")
		{
			//die("You Are Already Logged In From Another Location");
		}
	  	else
		{
			//die("Unknown Error, Please Contact Your Administrator");
		}
	 }
	 
	 mysqli_query($db,"UPDATE profile_tab SET last_login = '$today' WHERE username = '$username'");
	 close_db();	
} 

echo json_encode($response);

?>
