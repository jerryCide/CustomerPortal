<?
$user = "";
$pwd = "";
$answer = array();
if(isset($_REQUEST["user"]))
{
    $user =   $_REQUEST["user"];    
}
else
{
    die();
}

if(isset($_REQUEST["pwd"]))
{
    $pwd = $_REQUEST["pwd"];
}
else
{
    die();
}

include("vars.php");
//echo $user.$pwd;
//echo isLDAPLoginCorrect($user,$pwd);

if(!isLDAPLoginCorrect($user,md5($pwd)))
{
  array_push($answer,array("isCredentialCorrect" => false));
}
else
{
    array_push($answer,array("isCredentialCorrect" => true));
}

echo json_encode($answer);
 ?>