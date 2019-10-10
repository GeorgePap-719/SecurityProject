
<?php
	session_start();
	$errors = array(); //arxika kenos o pinakas
	$grNum=$mcNum=$titleErr=$subName=$testTit=$testTime="";
	$grErr=$mcErr=""; //save the number of Mc + Growth questions saved in d-base already
	$mcCount=$grCount="";
	
	if(isset($_POST['create']) && strcmp($_SESSION['user'],"admin") == 0 ){
		$subName = $_POST['subject'];
		$testTit = $_POST['title'];
		$testTime = $_POST['time'];
		$grNum = $_POST['growth'];
		$mcNum = $_POST['mc'];
		
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
		
		/*euresi sinolika olwn ton erwthsewn anaptiksis, aneksartitws mathimatos*/
		$allGr = "select * from questionNbelongsSub";
		$result = mysqli_query($conn,$allGr);
		$allGr = mysqli_num_rows($result);
		if(!$result){
			echo mysqli_error($conn);
			die();
		}
		
		/*euresi ton erwthsewn anaptiksis vasi mathimatos pou theloume*/
		$grCount = "select qid from questionNbelongsSub  where subName = '$subName' ";
		$result = mysqli_query($conn,$grCount);
		$grCount = mysqli_num_rows($result);
		if(!$result){
			echo mysqli_error($conn);
			die();
		}
		
		/*euresi sinolika olwn ton erwthsewn epilogis, aneksartitws mathimatos*/
		$allMc = "select * from questionMcbelongsSub";
		$result = mysqli_query($conn,$allMc);
		$allMc = mysqli_num_rows($result);
		if(!$result){
			echo mysqli_error($conn);
			die();
		}
		
		/*euresi ton erwthsewn epilogis vasi mathimatos pou theloume*/
		$mcCount = "select qid from questionMcbelongsSub where subName = '$subName' ";
		$result = mysqli_query($conn,$mcCount);
		$mcCount = mysqli_num_rows($result);
		if(!$result){
			echo mysqli_error($conn);
			die();
		}
		
		if($grNum > $grCount){
			//not enough normal questions for the creation
			array_push($errors,"<br> Not enough growth questions in db!");
			$grErr = "There are only ".$grCount." growth questions available!";
		}
		
		if($mcNum > $mcCount){
			//not enough mc questions for the creation
			array_push($errors,"<br> Not enough mc questions in db!");
			$mcErr = "There are only ".$mcCount." mul.choice questions available!";
		}
		
			
		if( ($mcNum <= $mcCount) && ($grNum <= $grCount) ){
		/*--- telos elegxou gia errors ---*/
			if( count($errors) == 0){
				/* add questions in test */
				
				$q = "insert into test(title,time,subName) values ('$testTit','$testTime','$subName')";
				$result = mysqli_query($conn,$q);
				if(!$result){
					echo mysqli_error($conn);
					die();
				}

				$idArr = array();
				
				/* load random id from Growth-Normal questions and add to test*/
				$idArr = range(1,$allGr);
				shuffle($idArr);
				$i=0;
				$countAr=0;
				while($i < $grNum){
					$qid = $idArr[$countAr];
					
					$q = "select qid from questionNbelongsSub where subName = '$subName' AND qid = '$qid' ";
					$result = mysqli_query($conn,$q);
					$count = mysqli_num_rows($result);
					if(!$result){
						echo mysqli_error($conn);
						die();
					}
					
					if($count != 0 ){ 
						$q="insert into questionNbelongsTest(qid,testTit) values('$qid','$testTit')";
						$result = mysqli_query($conn,$q);
						if(!$result){
							echo mysqli_error($conn);
							die();
						}
						$i++;
					} 
					$countAr++; 
				}
				
				unset($idArr); //clean array
				$idArr=array();
				
				/* load random id from mul. choice questions and add to test*/
				$idArr = range(1,$allMc);
				shuffle($idArr);
				$i=0;
				$countAr=0;
				while($i < $mcNum){
					$qid = $idArr[$countAr];
					$q = "select qid from questionMcbelongsSub where subName = '$subName' AND qid = '$qid' ";
					$result = mysqli_query($conn,$q);
					$count = mysqli_num_rows($result);
					if(!$result){
						echo mysqli_error($conn);
						die();
					}
					
					if($count != 0 ){ 
						$q="insert into questionMcbelongsTest(qid,testTit) values('$qid','$testTit')";
						$result = mysqli_query($conn,$q);
						if(!$result){
							echo mysqli_error($conn);
							die();
						}
						$i++;
					} 
					$countAr++; 
				}
			}
	
			echo "<span style='color:red'><h3>&nbsp;&nbsp;&nbsp;&nbsp; Test created successfully! <br> </h3> </span>";
			sleep(10); // sleep 10sec gia na emfanistei to mnma 
			echo "<br><hr>";
			echo " <script> location.replace('unset.php'); </script>";
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
			<input type="text" name="time" placeholder="in minutes" maxlength="10" size="7" value="<?php echo $testTime; ?>"/ required>
			<br>
			
			<label> <b>&#9656; Number of multiple choice questions: </b> </label>
			<input type="text" name="mc" maxlength="10" size="5" required> <?php echo "<span style='color:red'> $mcErr </span>" ?>
			<br>
			
			<label> <b>&#9656; Number of normal-growth questions: </b> </label>
			<input type="text" name="growth" maxlength="10" size="5"required> <?php echo "<span style='color:red'> $grErr </span>" ?>
			<br>
			
			<input type="submit" name="create" value="Create test!">
			<br>
		</form>
	</div>		
	
</body>
</html>



