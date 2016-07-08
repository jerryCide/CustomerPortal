<table width="100%" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0">

<tr>

<td>

<?php

@include("vars.php");
$count = 0;
//open_db();

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
$dn = "OU=MWH-OU,DC=mwh,DC=gov,DC=local";

// Specify only those parameters we're interested in displaying
$attrs = array("displayname","cn","sn","givenname","userPrincipalName","samaccountname","telephonenumber","memberOf","distinguishedName","ou");




$filter = "(|(samaccountname=*))";

$search = ldap_search($ad, $dn, $filter,$attrs)or die (ldap_err2str(ldap_errno() ));

$entries = ldap_get_entries($ad, $search);

if ($entries["count"] > 0) 
{

	for ($i=0; $i<$entries["count"]; $i++) 
	{
		
		$count++;
?>

<table cellpadding="0" cellspacing="0" width="100%" >
	<tr>
		<td>
        	<?php $ent_split = explode(",",substr($entries[$i]["dn"],strpos($entries[$i]["dn"],"OU=")+3)); ?>
        	 <b><font size="5"><?=$entries[$i]["sn"][0]?></font></b><br><font color="#999999"><?=$ent_split[0]?></font>
             
  		</td>
    </tr>
   </table>
	<input type="hidden" value="<?=$entries[$i]["givenname"][0]?>" id="fName_pick_<?=$count?>" />
    <input type="hidden" value="<?=$entries[$i]["sn"][0]?>" id="lName_pick_<?=$count?>" />
    <input type="hidden" value="<?=$entries[$i]["samaccountname"][0]?>" id="username_pick_<?=$count?>" />
    
<?php
	}

} 
else 
{
   echo "<p>No results found!</p>";
}

ldap_unbind($ad);

?>

</td>
</tr>
</table>