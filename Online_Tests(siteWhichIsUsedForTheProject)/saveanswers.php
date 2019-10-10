<?php
    session_start();

	if(isset($_POST['finish'])){
		$n=$_SESSION['user'];
        $t=$_SESSION['test'];        
	
		$serverName = "localhost";
		$userName = "root";
		$password = "";
		$db = "2249802_tests";  	
		$conn = mysqli_connect($serverName,$userName,$password,$db);                
		if(!$conn){
			echo "Sorry,an error occurred. Please try again!"; //db error connection
			die();                                
		}  
		
		$q="insert into writesTest(username,test_title) values('$n','$t')";
		$result = mysqli_query($conn,$q);
			
		if(!result){
			echo mysqli_error($conn);
			die();
		}
		
		$optArr=array();
		$optIds=array();
		
		$sum = count($_POST['option']);
		if($sum>0){
			$optArr = $_POST['option'];
			$optIds = $_POST['mc_id'];
		//insert answers
			for($i=0; $i<$sum; $i++){
				
				$k = "insert into UserAnswersQuestionMc(username,qid,answer) values('$n','$optIds[$i]','$optArr[$i] ' )";
				$result = mysqli_query($conn,$k);

				if(!result){
					echo mysqli_error($conn);
					die();
					}
				}
		}
		
		$optArr2=array();
		$optIds2=array();
		
		$sum = count($_POST['answers']);
		if($sum>0){
			$optArr2 = $_POST['answers'];
			$optIds2 = $_POST['gr_id'];
		//insert answers
			for($i=0; $i<$sum; $i++){	
				$k = "insert into UserAnswersQuestionN(username,qid,answer) values('$n','$optIds2[$i]','$optArr2[$i]')";
				$result = mysqli_query($conn,$k);

				if(!result){
					echo mysqli_error($conn);
					die();
					}
				}
				
		}
        unset($_POST['finish']); //unset  gia na min ksanampei karfwta me url
		unset($_SESSION['test']);
		header('Location:www.php');
		
	}
	else{
		header('Location:page2.php');
	}

?>