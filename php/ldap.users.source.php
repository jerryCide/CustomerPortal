<?php
@$onClick = $_REQUEST['onClick'];

if(empty($_REQUEST['onClick']))
{
	$onClick = "alert('Sorry, No Action Coded Here')";
}

@include("vars.php");
$count = 0;
//openDb();

// Designate a few variables
$host = $ldap_server;
$user = $ldap_admin;
$pswd = $ldap_password;

$ad = ldap_connect($host) or die( "Could not connect!" );

// Set version number
ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3) or die ("Could not set ldap protocol");

// Binding to ldap server
$bd = @ldap_bind($ad, $user, $pswd) or die ("COULD NOT BIND, REPORT ERROR TO DATABASE ADMIN");

// Create the DN
$dn = $ldap_root_dn;

// Specify only those parameters we're interested in displaying
$attrs = array("displayname","cn","sn","givenname","userPrincipalName","samaccountname","telephonenumber","memberOf","distinguishedName","ou");

//get passe username/search string

$query = $_REQUEST['query'];

//filter results by search string
$filter = "(|(name=$query*)(samaccountname=$query*)(sn=$query*))";

$search = ldap_search($ad, $dn, $filter,$attrs)or die ("ldap search failed");

$entries = ldap_get_entries($ad, $search);

if ($entries["count"] > 0) 
{
	$array = array();
	
	for ($i=0; $i < $entries["count"]; $i++) 
	{
		//process all results from LDAP
		@$array = $entries[$i]["samaccountname"][0];
		
		$count++;
	}
} 
ldap_unbind($ad);

// return json array
echo json_encode($array);



?>

