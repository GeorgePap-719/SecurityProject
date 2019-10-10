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
	$uname=$pass=$unameErr=$passErr=$logErr="";
	
	if(isset($_POST["forgotPass"])){
		
		$res = post_captcha($_POST['g-recaptcha-response']); 
		if (!$res['success']) {
			// What happens when the CAPTCHA wasn't checked
			echo '<p>Please make sure you check the security CAPTCHA box.</p><br>';
		} 
		else{ // If CAPTCHA is successfully completed...
			//db connect
			$conn = mysqli_connect("localhost","root","","2249802_tests");	
			if(!$conn) die();
			//end
			
			$email = $conn->real_escape_string($_POST["email"]);
			$q = "select * from user where username='$uname' AND pws='$pass'";
			$data = $conn->query("SELECT username from user where email='$email' ");
			
			if($data->num_rows >0){
				$str = "0123456789qwertyuiopasdfghjklxzcvmn"; //random string to generate the reset pass
				$str = str_shuffle($str);
				$str = substr($str,0,10); //generate random pass... 10 prwtous apo to shuffled string
				$url = "https://127.0.0.1/Tests_forget/resetPassword.php?token=$str&email=$email";
				
				if( mail($email,'Reset password','To reset your password,please visit this url: '.$url, "From: parkouronlinedadada@gmail.com\r\n") ){
					echo "<span style='color:red'> Please check your email! Reset password url has been sent! </span>";
					$conn->query("UPDATE user SET token='$str' WHERE email='$email'");
				}
				else echo "<span style='color:red'> Try again </span>";	
			}
			else echo "<span style='color:red'> Wrong e-mail! </span>";
		}
	}
?>

<!DOCTYPE html>
<head>
	<link rel="stylesheet" type="text/css" href="ButtsStyle.css" />
	<link rel="stylesheet" type="text/css" href="Online_Tests_graphics.css" >
	<script src='https://www.google.com/recaptcha/api.js'></script> 
	<title>Forgot your Password?</title>
</head>

<html>
	<body>
	
	<h1 class="titPos"> <i>Online Tests</i> </h1>
	<h1 class="entryPos"> <i id='page'>Reset my Password</i> </h1>
	
	<form id='signPos' class="entryButtonWrap" action="forgotPassword.php" method="post">
		<input type="email" name="email" placeholder="Email" maxlength="500" required > <br>
		<div class="g-recaptcha" data-sitekey="6LfwI0QUAAAAADNItY-Hguiin4s5Ojn2N18EPoc_"></div>  
		<br>
		<input type="submit" name="forgotPass" class="login-button" value="Request Password"/ > <br>
	</form>
	</body>
</html>