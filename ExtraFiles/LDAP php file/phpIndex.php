<?php	
	session_start();
	$uname=$pass=$unameErr=$passErr=$logErr="";
	if(isset($_POST['login'])){
		
		$ldapServer = 'localhost';
		$ldapPort = 389;
		$ldapBase = 'CN = Manager, c=EL';
		$ldapPws = 'ellas';
		$ldapConn = ldap_connect($ldapServer, $ldapPort);
		
		if(!$ldapConn){
			$this->getRequest()->setError('name','Κάποιο πρόβλημα προέκυψε');
			$this->loginldap=true;
			$this->setTemplate('login');
			//return sfView::SUCCESS;
		}
		else echo "Succesful connect \n";
		
		ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION,3);
		//ldap_set_option($ldapConn, LDAP_OPT_REFERRALS, 0 );
		
		if ($r=ldap_bind($ldapConn,$ldapBase,$ldapPws)){
			echo "bind".$r."";
			
			echo "\n  Success admin\n";
			//$filter = 'c=EL,o=Online_Tests,ou=Users,cn=george';
			//$filter = 'c=EL,o=Online_Tests,ou=Users,cn=*';
			//$filter = 'c=EL,o=Online_Tests,ou=Users';
			//$filter = 'c=EL,o=Online_Tests,ou=*';
			//$filter = 'c=EL,o=Online_Tests';
			//$filter = 'c=EL,o=*';
			//$filter = 'c=EL';
			
			//$filter = 'o=Online_Tests,ou=Users,cn=george';
			//$filter = 'o=Online_Tests,ou=Users,cn=*';
			//$filter = 'o=Online_Tests,ou=Users';
			//$filter = 'o=Online_Tests,ou=*';
			//$filter = 'o=Online_Tests';
			//$filter = 'o=*';
			
			//$filter = 'o=Online_Tests,cn=george';
			$filter = 'o=Online_Tests,cn=paviglas';
			
			//$filter = 'cn=paviglas';   
			//$filter = 'ou=Admin';   
			//$filter = 'ou=Admin,cn=paviglas';   
			//$filter = 'ou=*';   
			
			$result = ldap_search($ldapConn,$ldapBase,$filter) or exit("Unable to search");
			//$result = ldap_search($ldapConn,'CN=Manager, c=EL',$filter) or exit("Unable to search");
			echo "".$result."";
			
			$entries = ldap_get_entries($ldapConn,$result);
			echo "".$entries."";
			
			print "<pre>";
			print_r ($entries);
			print "</pre>";
		}
		else echo "invalid admin";
		
		
		
		
		
		
		
		//$ldaprdn = $_POST['username'];
		//$ldappass = $_POST['password'];
		
		//$ldaprdn  = 'uname';      // ldap rdn or dn
		//$ldappass = 'password';  // associated password

		
		/*
		$q = "select * from user where username='$uname' AND pws='$pass' ";

		if(mysqli_num_rows($result) > 0 ){
			//Successfull login
			if(strcmp($uname,"admin") == 0){		
				$_SESSION['user'] = $uname;
				header('Location: page2admin.php');
			}
			else{			
				$_SESSION['user'] = $uname;
				header('Location: page2.php');
			}
		}
		else{
			$logErr = "Wrong username or password.";
			$unameErr = "Check your username again!";
			$passErr = "Check your password again!";
		}
		*/
	}
?>
<!-- ~~~~~~~~~~~~~~~~END OF PHP LOGIN POST ~~~~~~~~~~~~~~~~ -->	
		
<!DOCTYPE html>
<html>
	<head>
		<script src="ChangeTabs.js"> </script>
		<link rel="stylesheet" type="text/css" href="ButtsStyle.css" />
		<link rel="stylesheet" type="text/css" href="Online_Tests_graphics.css" >
		<title>Online Student Tests</title>
	</head>

<body>
	<h1 class="titPos"> <i>Online Tests</i> </h1>
	<h1 class="entryPos"> <i id='page'>Login Page</i> </h1>
	<div id='container'>

		<div id='signPos'><button class="entryButtonWrap" onclick="change('signUp')"> Sign Up &#8594 </button> </div>

		<img src="user7.png">
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
		<div>
			<?php echo "<span style='color:red'> $logErr </span>"?><br>
			<label class="label" > <b> Username: </b> </label> <?php echo "<span style='color:red'> $unameErr </span>"?>
			<br>
			<input type="text" name="username" placeholder="Enter username" value="<?php echo $uname; ?>"/ required > 
		</div>
		<div>
			<label class="label" > Password: </label> <?php echo "<span style='color:red'> $passErr </span>"?>
			<br>
			<input type="password" name="password" placeholder="Enter password" value="<?php echo $pass; ?>"/ required >
		</div>
			<input type="submit" name="login" value="Login" class="login-button">
			<br>
			<input type="checkbox" checked="checked"> <b style="color:white"> Remember me </b>
			<br>
			<a href="#" style="color:lightblue" >Forgot password?</a>
		</form>
	</div>

	<div id='signUp'>
	
		<div id='logPos'><button class="entryButtonWrap" onclick="change('container')"> &#8592 Login </button> </div>
		
		<img src="add.png">
		<form action="register.php" method="post">
		<div>
			<input type="text" name="fname" placeholder="First name" maxlength="50" required>
			<input type="text" name="lname" placeholder="Last name" maxlength="50"  required>
			<input type="text" name="username" placeholder="Username (unique)" maxlength="500"  required>
			<input type="password" name="password" placeholder="Password" maxlength="500"  required>
			<input type="password" name="ver_pws" placeholder="Enter password again" maxlength="500"  required>
			<input type="email" name="email" placeholder="E-mail (valid)" maxlength="500" required>
			<br>
			<input type="date" name="born" required>
			<br>
			
			<br>
			
			<input type="radio" name="gender" value="male" checked>
				<b style="color:#fff"> Male </b>
			<input type="radio" name="gender" value="female">
				<b style="color:#fff"> Female </b>
			<br>
		</div>
		<input type="submit" name="register" value="Register" class="login-button">
		</form>
	</div>
	<br><br>
	<hr>
	<p class="footer"> <u>Creators</u>: <br>Nikos Kaloritis 2114151, Viglas Panagiwths - 2114041, Iwanna Kelemati 2114230, Giwrgos Papadopoulos - 2114077 &#169</p>
	
	
	
	<script>
		var tab;
		tab = document.getElementById('signUp');
		tab.style.display = "none";
	</script>
	
</body>
</html>

<!-- Copyright message -->
<?php
	echo "<p class='footer' >Copyright &copy; 2016-" . date("Y") . " </p>";
?>
