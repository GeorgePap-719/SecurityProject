<?php 
	session_start();
	
	$err="";
	$err2="";
	$oldPws=$newPws=$newPws2="";
	
	if(isset($_SESSION['user'])){
		$n=$_SESSION['user'];
		echo "<span id='hello' span style='color:red' > <br> &#160; You are going to change your password, $n! </span> <br>";
		
		if(isset($_POST['change'])){
			$errors = array(); //arxika kenos o pinakas
			
			//db connect
			$conn = mysqli_connect("localhost","root","","2249802_tests");	
			if(!$conn) die();
			//ends	
			$oldPws = $conn->real_escape_string($_POST['oldPws']);
			
			//check if the old pass is correct
			$data = $conn->query("select * from user where username='$n' AND pws='$oldPws'");
			
			if($data->num_rows >0){
				/*correct pws*/
			}
			else{
				array_push($errors,"<br>  - Old password is wrong!");
			}
			$newPws = $conn->real_escape_string($_POST['newPws']);
			$newPws2 = $conn->real_escape_string($_POST['newPws2']);
			
			if(strcmp($newPws,$newPws2) != 0 ) array_push($errors,"<br>  - Passwords don't match!");
			//password policy
			if( strlen($newPws) >= 10  and ( preg_match('/[a-z]/', $newPws) ) and ( preg_match('/[A-Z]/', $newPws) )  and ( preg_match('/[0-9]/', $newPws) ) ) {
				//valid pws
			}
			else array_push($errors,"<br>  - Password must contain at least one number, one upper and one lower case character and minimum length = 10");
			
			if( count($errors) == 0){
				$conn->query("UPDATE user SET pws = '$newPws' WHERE username='$n'");
				
				$err="Your password has been successfully changed!";
				$err2="";
				
				echo " <br><br> <a href='page2.php'> <span class='headback'> Go back to main page! </span> </a>";
				
			}
			else{
				$err="Password must contain at least one number, one upper and one lower case character and minimum length = 10";
				$err2="Check again your inputs. Old password must be correct. New passwords must match";
			}
		}
		
	}
	else{
		header('Location:phpIndex.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="RegStyle.css" >
	<link rel="stylesheet" type="text/css" href="ButtsStyle.css" />
	<link rel="stylesheet" type="text/css" href="Online_Tests_graphics.css" >
	<title>Change user password</title>
</head>
<body class="main">
	<div id='container'>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
		<div>
			<?php echo "<span style='color:red'> $err </span>"?><br>
			<?php echo "<span style='color:red'> $err2 </span>"?><br>
			<label class="label" > <b> Old Password: </b> </label> 
			<br>
			<input type="password" name="oldPws" placeholder="Old password" maxlength="500"  required>
		</div>
		<div>
			<label class="label" > <b> Password: </b> </label> 
			<br>
			<input type="password" name="newPws" placeholder="New password" maxlength="500"  required>
			<br>
			<input type="password" name="newPws2" placeholder="Repeat new password" maxlength="500"  required>
		</div>
			<br>
			<input type="submit" name="change" value="Change" class="login-button">
			<br>
		</form>
	</div>	
</body>
</html>