<?php 
session_start();
/*display test title + subjet Name at top of the page!*/
	if(isset($_SESSION['testTit']) && strcmp($_SESSION['user'],"admin") == 0){
		$testTit = $_SESSION['testTit'];
		$subName = $_SESSION['subName'];
		echo "<span id='hello'> <br> &#160; Current test: $testTit, <br> &#160; Subject: $subName </span> <br>";
	}	
	else{ 	/* if button 'done' is not set!*/
		header('Location:create.php');
	}
	
	/* add - save mc question */
	if(isset($_POST['done'])){ 
		/*connect to db*/
		$serverName = "localhost";
		$userName = "root";
		$password = "";
		$db = "2249802_tests";
		$conn = mysqli_connect($serverName,$userName,$password,$db);
		if(!$conn){
			die();
		}
		
		$question = $conn->real_escape_string($_POST['question']);
	
		$q ="insert into questionN(query) values('$question')";
		$result = mysqli_query($conn,$q);
		if(!$result){
			echo mysqli_error($conn);
			die();
		}
		
		$countId = "select * from questionN";
		$result = mysqli_query($conn,$countId);
		$countId = mysqli_num_rows($result);
		if(!$result){
			echo mysqli_error($conn);
			die();
		}
		
		$q="insert into questionNbelongsSub(qid,subName) values('$countId','$subName')";
		$result = mysqli_query($conn,$q);
		if(!$result){
			echo mysqli_error($conn);
			die();
		}
			
		$q="insert into questionNbelongsTest(qid,testTit) values('$countId','$testTit')";
		$result = mysqli_query($conn,$q);
		if(!$result){
			echo mysqli_error($conn);
			die();
		}
		
		echo "<span style='color:red'><h3>&nbsp;&nbsp;&nbsp;&nbsp; Question saved successfully! <br> </h3> </span>";
		echo "<span><h4>&nbsp;&nbsp;&nbsp;&nbsp; Do you want to add more questions? </h4> </span>";
		echo "&nbsp;&nbsp;&nbsp;&nbsp; <button onclick=location.href='addMc.php';>Yes,add multiple choice question.</button>
		&nbsp;&nbsp; <button onclick=location.href='addGrowth.php';>Yes,add growth question.</button>&nbsp;&nbsp;
		&nbsp;&nbsp; <button onclick=location.href='unset.php';>No,the test is complete!</button>&nbsp;&nbsp;";
		echo "<br><hr>";
	}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="wwwcss.css">
    <title>Adding question..</title>
</head>

<body class="main">
	<button onclick="location.href='page2admin.php';" class="goback"></button>
    <button onclick="location.href='logout.php';" class="logoutb"></button>
    
	<div class="content" id='mc'>
		<h3> <u> Normal question</u> </h3>
  		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
		
			<p>&#9656; <b>Add your question query..</b> </p>
			&nbsp;<textarea style='width:400px height:95px;' name='question' maxlength='499' required> </textarea> <br><br>

			
			<input type='submit' name='done' value='Save question!'>
		</form>
	</div>
	
</body>
</html>


	