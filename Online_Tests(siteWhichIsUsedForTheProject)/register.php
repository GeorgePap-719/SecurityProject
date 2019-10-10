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
	$errors = array(); //arxika kenos o pinakas
	
	//elegxos an patithike to koumpi i oxi
	if( isset($_POST['register']) ){
		$res = post_captcha($_POST['g-recaptcha-response']); 
		if (!$res['success']) {
			// What happens when the CAPTCHA wasn't checked
			echo '<p>Please make sure you check the security CAPTCHA box.</p><br>';
			echo " <br><br> <a href='phpIndex.php'> <span class='headback'> Head back to register form! </span> </a>";
		} 
		else{ // If CAPTCHA is successfully completed...
			//db connect
			$conn = mysqli_connect("localhost","root","","2249802_tests");	
			if(!$conn) die();
			//ends

			$fname = $conn->real_escape_string($_POST['fname']);
			//$fname = preg_replace('/[^\p{L}\p{N}\s]/u', '', $fname);
			
			$lname =$conn->real_escape_string( $_POST['lname']);
			//$lname = preg_replace('/[^\p{L}\p{N}\s]/u', '', $lname);
			
			$uname = $conn->real_escape_string($_POST['username']);
			//$uname = preg_replace('/[^\p{L}\p{N}\s]/u', '', $uname);
			
			$pws = $conn->real_escape_string($_POST['password']);
			//$pws = preg_replace('/[^\p{L}\p{N}\s]/u', '', $pws);
			
			$Vpws =$conn->real_escape_string( $_POST['ver_pws']);
			//$Vpws = preg_replace('/[^\p{L}\p{N}\s]/u', '', $Vpws);
			
			$mail =$conn->real_escape_string( $_POST['email']);
			$date = $_POST['born'];
			$gen = $_POST['gender'];
			
			//register authentication
			if( strlen($fname) < 2 ) array_push($errors,"  - First name must have at least 2 characters!");
			if( strlen($lname) < 2 ) array_push($errors,"<br>  - Last name must have at least 2 characters!");
			if( strlen($uname) < 5 ) array_push($errors,"<br>  - Username must have at least 5 characters!");		
			if(strcmp($pws,$Vpws) != 0 ) array_push($errors,"<br>  - Passwords don't match!");
			//password policy
			if( strlen($pws) >= 10  and ( preg_match('/[a-z]/', $pws) ) and ( preg_match('/[A-Z]/', $pws) ) and preg_match('/[0-9]/', $pws ) ) {
				//valid pws
			}
			else array_push($errors,"<br>  - Password must contain at least one number, one upper and one lower case character and minimum length = 10");
			
			/*--- check for uname-email duplicate ---*/
			$dupuname = "select username from user where username='$uname'";
			$resuname = mysqli_query($conn,$dupuname);
			if(mysqli_num_rows($resuname) > 0 ){
				//same username found
				array_push($errors,"<br>  - This Username has already been taken.Please,choose another!");		
			}
			
			$dupmail = "select email from user where email='$mail'";
			$resmail = mysqli_query($conn,$dupmail);

			if(mysqli_num_rows($resmail) > 0 ){
				//same email found
				array_push($errors,"<br>  - This e-mail has already been taken.Please,choose another!");	
			}
			/*--- telos elegxou gia mail/username ---*/
			
			if( count($errors) == 0){
				
				//$q = "insert into user(fname,lname,username,pws,email,gen,date) values ('$fname','$lname','$uname','$pws','$mail','$gen','$date')";
				//$result = mysqli_query($conn,$q);
				
				$data = $conn->query("insert into user(fname,lname,username,pws,email,gen,date) values ('$fname','$lname','$uname','$pws','$mail','$gen','$date')");
				
				if($data === false){
					echo $conn->error;
					die();
				}
				else{
					echo "<span class='regi'> <br>Congratulations $fname $lname <br>
						you have successfully registered to our site! </span>";
					echo "<span class='regi'> <br><br> E-mail: $mail </span> ";
					echo "<span class='regi'> <br> Username: $uname </span> ";
					echo "<span class='regi'> <br> Password: ***** </span>";
					//$age = date("Y") - $date ;
					//echo "<span class='regi'> <br> Age: $age </span>";
					echo " <br><br> <a href='phpIndex.php'> <span class='headback'> Head back to Login page, to Sign In! </span> </a>";
				}
			}
			else{
				$arLen = count($errors);
				
				echo "<span class='regi' style='color:red'>$arLen error(s) found: </span> <br>";
				for($i=0; $i < $arLen; $i++) echo "<span class='regi'> $errors[$i] </span>";
				
				echo " <br><br> <a href='phpIndex.php'> <span class='headback'> Head back to register form! </span> </a>";
			}
		}
	}
	//an den patithike to submit
	else{
		header('Location: index.html');
	}
?>

<link rel="stylesheet" type="text/css" href="RegStyle.css" >