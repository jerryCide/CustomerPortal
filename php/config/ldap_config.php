<?php
global $ldap_server;
global $ldap_admin;
global $ldap_password;
global $ldap_root_dn;
global $ldap_domain;

/*
$ldap_server = "ldap://192.168.7.5:389";
$ldap_admin = "zeus@mwh.gov.local";
$ldap_password= "H1gh53cur1ty";
$ldap_root_dn = "OU=MWH-OU,DC=MWH,DC=GOV,DC=LOCAL";
$ldap_domain = "MWH.GOV.LOCAL";*/


//LOCAL TESTING CREDENTIALS
$ldap_enable = 0;
$ldap_server_ip = "192.168.137.60";
$ldap_server = "ldap://".$ldap_server_ip;
$ldap_admin = "zeus@cide.local";
$ldap_password= "H1gh53cur1ty";
$ldap_root_dn = "OU=MWH-OU,DC=CIDE,DC=LOCAL";
$ldap_domain = "CIDE.LOCAL";
?>