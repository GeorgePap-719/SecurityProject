<?php

	 

function ldap_authenticate($user, $password) {
	ini_set('display_errors', 'on');
	// Active Directory server
	$ldap_host = "LDAP://localhost";

	// Active Directory DN
	$ldap = ldap_connect($ldap_host,666) or die ("Could not connect to ldap");

	ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);

	$what = array( "admins", "developpers", "clients" );

	for ( $i = 0; $i < 3; ++$i ) {

		$ldap_dn = ",cn=" . $what[$i] . ",dc=officers,dc=com";
		$ldaprdn = "uid=" . $user . "," . "cn=" . $what[$i] . ",dc=officers,dc=com";//'cn=' . $user . $ldap_dn; 
		 echo $ldaprdn . "<br>";
		 echo "try " . $ldaprdn;
		$bind = ldap_bind($ldap, $ldaprdn, ($password));
		//echo $bind . "<br>";
		$justthese = array("uname", "sn");

		if($bind) {
			echo "<h2>loggin :D</h2>";
			$result = ldap_search( $ldap, $ldaprdn, "uid=$user", $justthese ) or die ("Error in query");
    
			//print_r( $result );
			$data = ldap_get_entries($ldap, $result);
			//print_r( $data );

			$_SESSION['fullname'] = $data[0]['uname'][0] . " " . $data[0]['sn'][0];

			//echo "fullname := " . $_SESSION['fullname'];

			return true;
		}
	}

	
	//echo "<br><hr>";

	return false;
}
//tests
ldap_authenticate( "velly","abcd" );
ldap_authenticate( "sotirisnik", "abcd" );
ldap_authenticate( "ttest","abcdef" );
?>
