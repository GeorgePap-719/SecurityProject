<?php
	session_start();
	$errors = array(); //arxika kenos o pinakas
	$titleErr=$subName=$testTit=$testTime="";
	
	if(isset($_POST['create']) && strcmp($_SESSION['user'],"admin") == 0 ){
		$subName = $_POST['subject'];
		$testTit = $_POST['title'];
		$testTime = $_POST['time'];
		
		$serverName = "localhost";
		$userName = "root";
		$password = "";
		$db = "2249802_tests";
		$conn = mysqli_connect($serverName,$userName,$password,$db);
		if(!$conn){
			echo "Sorry,an error occurred. Please try again!"; //db error connection
			die();
		}
		
		$duptit = "select title from test where title='$testTit' ";
		$restit = mysqli_query($conn,$duptit);
		if(mysqli_num_rows($restit) > 0 ){
			//same test title found
			array_push($errors,"<br> Test's title has already been taken.Please,choose another!");
			$titleErr = "Test's title has already been taken!";
		}
		else{
		/*--- telos elegxou gia title name ---*/
			if( count($errors) == 0){
				/* add values in test */
				$q = "insert into test(title,time,subName) values ('$testTit','$testTime','$subName')";
				$result = mysqli_query($conn,$q);
				if(!$result){
					echo mysqli_error($conn);
					die();
				}
			$_SESSION['testTit'] = $testTit;
			$_SESSION['subName'] = $subName;
			
			echo "<span style='color:red'><h3>&nbsp;&nbsp;&nbsp;&nbsp; Test created successfully! <br> </h3> </span>";
			echo "<span><h4>&nbsp;&nbsp;&nbsp;&nbsp;  What type of question you want to add? </h4> </span>";
			echo "&nbsp;&nbsp;&nbsp;&nbsp; <button onclick=location.href='addMc.php';>Multiple choice</button> &nbsp;&nbsp; <button onclick=location.href='addGrowth.php';> Growth</button>&nbsp;&nbsp;";
			echo "<br><hr>";
			}
		}
	}
	else if(strcmp($_SESSION['user'],"admin") != 0){	/* ginetai redirect apo to addMc.. opote etsi tha ton petaxei ekso ton user*/
		header('Location:phpIndex.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="wwwcss.css">
    <title>Creating test...</title>
</head>

<body class="main">
	<button onclick="location.href='page2admin.php';" class="goback"></button>
    <button onclick="location.href='logout.php';" class="logoutb"></button>
	
	<div>
		<h2> <u>Create test: </u> </h2>
  		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			<label> <b>&#9656; Give subject name: </b> </label>
			<input type='text' name='subject' placeholder="www" maxlength="29" size="15" value="<?php echo $subName; ?>"/ required>
			<br>
			
			<label> <b>&#9656; Test's title: </b> </label> 
			<input type="text" name="title" placeholder="www_test01" maxlength="29" size="15" value="<?php echo $testTit; ?>"/ required> <?php echo "<span style='color:red'> $titleErr </span>"?>
			<br>
			
			<label> <b>&#9656; Test's time duration: </b> </label>
			<input type="text" name="time" placeholder="in minutes" maxlength="10" size="5" value="<?php echo $testTime; ?>"/ required>
			<br>
			<input type="submit" name="create" value="Create test!">
			<br>
		</form>
	</div>		
	
</body>
</html>



