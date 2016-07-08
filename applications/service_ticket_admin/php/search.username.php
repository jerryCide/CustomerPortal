<?php
@include("../../../php/vars.php");
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
$dn = $ldap_root_dn;

// Specify only those parameters we're interested in displaying
$attrs = array("displayname","cn","sn","givenname","userPrincipalName","samaccountname","telephonenumber","memberOf","member","distinguishedName","OU","mail","homedirectory");

$username = $_REQUEST['username'];


$filter = "(|(name=$username*)(samaccountname=$username*)(sn=$username*)(mail=*$username*))";

$search = ldap_search($ad, $dn, $filter,$attrs)or die ("ldap search failed");

$entries = ldap_get_entries($ad, $search);

?>
<div class="list-group">
<?php

if ($entries["count"] > 0) 
{

	for ($i=0; $i<$entries["count"]; $i++) 
	{
		$username = $entries[$i]["samaccountname"][0];
		open_db();
		$p_res = mysqli_query($db,"SELECT * FROM profile_tab as pt, dept_tab as dt WHERE pt.username = '$username' AND dt.dept_id = pt.dept_id");
		close_db();
		$p_row = mysqli_fetch_array($p_res,MYSQL_ASSOC);
		$count++;
?>


  			<a href="?app=global_admin&page=apps" class="list-group-item" onclick="insertInfo_st(<?=$count?>); return false;"><b><font size="3"><?=$entries[$i]["givenname"][0]?></font>&nbsp;<font size="5"><?=$entries[$i]["sn"][0]?></font></b><br><font color="#999999"><?=$ent_split[0]?></font>
            <?php 
			 $ent_split = explode(",",substr($entries[$i]["dn"],strpos($entries[$i]["dn"],"OU=")+3));	 
		 ?>
  	<input type="hidden" value="<?=$entries[$i]["givenname"][0]?>" id="fName_pick_<?=$count?>" />
    <input type="hidden" value="<?=$entries[$i]["sn"][0]?>" id="lName_pick_<?=$count?>" />
    <input type="hidden" value="<?=$entries[$i]["samaccountname"][0]?>" id="username_pick_<?=$count?>" />
    <input type="hidden" value="<?=$entries[$i]["mail"][0]?>" id="email_pick_<?=$count?>" />	
    </a>

    
<?php
	}
	
	?>
    
    <?php

} 
else 
{
   echo "<span class=\"list-group-item\">No results found!</span>";
}

ldap_unbind($ad);

?>
</div>
