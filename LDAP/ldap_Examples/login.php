<?php

session_start();

$admins = ",cn=admins,ou=admins,dc=eclass,dc=gr";
$students = ",cn=students,ou=students,dc=eclass,dc=gr";

$ldapuser_admin  = 'cn=' . $_POST['myusername'] . $admins;
$ldapuser_doctor  = 'cn=' . $_POST['myusername'] . $students;
$ldappass = $_POST['mypassword'];

$ds=ldap_connect("localhost");

ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
 
if ($ds) { 
	$r=ldap_bind($ds, $ldapuser_admin, $ldappass);

	if ($r) {
		$_SESSION['myusername'] = $_POST['myusername'];

		header('Location: login/index.php');
    	} 
	else {
		$r=ldap_bind($ds, $ldapuser_doctor, $ldappass);
		if ($r){
			$_SESSION['myusername'] = $_POST['myusername'];

			header('Location: login/index.php');
		}
		else{
        		echo "Wrong credentials";
		}
    	}
 
} 
else {
	echo "Unable to connect to LDAP server";
}
?>
