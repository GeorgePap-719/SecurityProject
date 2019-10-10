<?php
    function post_captcha($user_response) {
        $fields_string = '';
        $fields = array(
			//private key
            'secret' => '6LfwI0QUAAAAAEJdIW8rTRdEv6og78Gx3Lm6ms9k', 
            'response' => $user_response
        );
        foreach($fields as $key=>$value)
        $fields_string .= $key . '=' . $value . '&';
        $fields_string = rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }
?>

<?php		
	session_start();
	$uname=$pass=$unameErr=$passErr=$logErr="";
	if(isset($_POST['login'])){
		
		$res = post_captcha($_POST['g-recaptcha-response']); 
		if (!$res['success']) {
			// What happens when the CAPTCHA wasn't checked
			echo '<p>Please make sure you check the security CAPTCHA box.</p><br>';
		} 
		else{ // If CAPTCHA is successfully completed...
			//db connect
			$conn = mysqli_connect("localhost","root","","2249802_tests");	
			if(!$conn) die();
			//ends
	
			//$uname = $_POST['username'];
			//$testuname = $uname;
			$uname = $conn->real_escape_string( $_POST['username'] );
			//$uname = preg_replace('/[^\p{L}\p{N}\s]/u', '', $uname);
			
			//$pass = $_POST['password'];
			//$testpass = $pass;
			$pass = $conn->real_escape_string( $_POST['password'] );
			//$pass = preg_replace('/[^\p{L}\p{N}\s]/u', '', $pass);
			
			/*an ta testuname,testpass den einai idia sto telos me ta arxika
			paei na pei oti eixan eidikous xaraktires pou afairethikan.
			opote den ton afinoume na mpei */
			
			$q = "select * from user where username='$uname' AND pws='$pass' ";
			$result = mysqli_query($conn,$q);

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
				$uname = '';
				$pass = '';
			
				$logErr = "Wrong username or password.";
				$unameErr = "Check your username again!";
				$passErr = "Check your password again!";
				
			/*	
				//--- ban user for 600secs if he tries 3 wrong passwords!---
				//exoume thema me tin metatropi tou datetime se int gia na kanoume tin afairesi me to lockout_time kai to first_failed_login!
				//o kwdikas einai swstos, mono i metatropi einai pou den leitourgei!
				
				$bad_login_limit = 3;
				$lockout_time = 600;
				
				$first_failed_login = $conn->query("SELECT first_failed_login from user where username='$uname' "); //retrieve from db
				$failed_login_count = $conn->query("SELECT failed_login_count from user where username='$uname' "); //retrieve from db
				$currentTime = time();

					if(($failed_login_count >= $bad_login_limit) and ( $currentTime - $first_failed_login  < $lockout_time)){
						echo "You are currently locked out.";
						exit();
					}
					else{
						if( time() - $first_failed_login > $lockout_time ) {
							// first unsuccessful login since $lockout_time on the last one expired
							$first_failed_login = time(); 
							$failed_login_count = 1; 
							$conn->query("UPDATE user SET first_failed_login = '$first_failed_login ', failed_login_count ='$failed_login_count' WHERE username='$uname' "); // commit to db
						} 
						else{
							$failed_login_count++;
							$conn->query("UPDATE user SET failed_login_count ='$failed_login_count' WHERE username='$uname' "); // commit to db
						}
						exit();
					}
			*/
			}
		}
	}
?>
<!-- ~~~~~~~~~~~~~~~~END OF PHP LOGIN POST ~~~~~~~~~~~~~~~~ -->	
		
<!DOCTYPE html>
<html>
	<head>
		<script src="ChangeTabs.js"> </script>
		<link rel="stylesheet" type="text/css" href="ButtsStyle.css" />
		<link rel="stylesheet" type="text/css" href="Online_Tests_graphics.css" >
		<script src='https://www.google.com/recaptcha/api.js'></script> 
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
			<div class="g-recaptcha" data-sitekey="6LfwI0QUAAAAADNItY-Hguiin4s5Ojn2N18EPoc_"></div> 
			<br>
			<input type="submit" name="login" value="Login" class="login-button">
			<br>
			<a href="forgotPassword.php" style="color:lightblue" >Forgot password?</a>
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
		<div class="g-recaptcha" data-sitekey="6LfwI0QUAAAAADNItY-Hguiin4s5Ojn2N18EPoc_"></div> 
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