<?php
	if(isset($_GET["email"]) && isset($_GET["token"])){
		//db connect
		$conn = mysqli_connect("localhost","root","","2249802_tests");	
		if(!$conn) die();
		//end
		
		$email = $conn->real_escape_string($_GET["email"]);
		$token = $conn->real_escape_string($_GET["token"]);
		
		$data = $conn->query("SELECT username from user where email='$email' AND token='$token' ");
		
		if($data->num_rows >0){
			$str = "0123456789qwertyuiopasdfghjklxzcvmn"; //random string to generate the reset pass
			$str = str_shuffle($str);
			$str = substr($str,0,10); //generate random pass... 10 prwtous apo to shuffled string
			
			$pws = $str;
			echo "Your new password is: ".$pws;
			
			$conn->query("UPDATE user SET pws = '$pws', token='' WHERE email='$email'");
		}	
		else echo "Please check your link";
	}
	else{
		exit();
	}
?>