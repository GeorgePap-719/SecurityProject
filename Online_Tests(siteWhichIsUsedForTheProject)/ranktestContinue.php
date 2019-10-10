<?php
    session_start();
    if(isset($_SESSION['user']) && isset($_SESSION['writesTest']) && strcmp($_SESSION['user'],"admin") == 0 ){
		$n=$_SESSION['user'];
        $n1= $_SESSION['writesTest']['username'];
		$n2=$_SESSION['writesTest']['test_title'];
		
        echo "<span id='hello'> <br>User:$n </span>";
		echo "<span id='hello' style='color:red'> <br>Selected student name: </span>".$n1;
		echo "<span id='hello' style='color:red'> <br>Selected test name: </span>".$n2;
		echo "<br>";
    }
	else{
        header('Location:phpIndex.php');
    }

	$serverName = "localhost";
	$userName = "root";
	$password = "";
	$db = "2249802_tests";
	
    $conn = mysqli_connect($serverName,$userName,$password,$db);
    if(!$conn){
        die();
    }
	$anMc="select qid from questionMcbelongsTest where testTit='$n2' ";
	$resultAnMc = $conn->query($anMc);   
    $anN="select qid from questionNbelongsTest where testTit='$n2'";
    $resultAnN = $conn->query($anN);       
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="wwwcss.css">
    <title>www</title>
</head>

<body class="main">
	<button onclick="location.href='ranktest.php';" class="goback"></button>
    <button onclick="location.href='logout.php';" class="logoutb"></button>
	<hr>
    <h2 style="color:#ff3300"><?php echo "&nbsp; Student's Answers: "?> </h2>

	<?php
		if ($resultAnMc->num_rows > 0) {
            while($rowMc = $resultAnMc->fetch_assoc()){
        echo "<div class='AllQuestions'>";
				$s=$rowMc["qid"];
	   
				$idMc = "select * from UserAnswersQuestionMc where username='$n1' and qid='$s'";
				$SelectidMc = mysqli_query($conn,$idMc);              
				
				$temp0 = "select * from questionMc where id='$s'";
				$SelectQueryMc = mysqli_query($conn,$temp0);    
				$array_question=array();
				
				echo"<br>";
				if ($r0 = mysqli_fetch_assoc($SelectQueryMc)){
					echo "<div class='Mc_Text'> <b><font size='4'> &#9656; " . $r0["query"]. "</font></b> </div>";    
				}
				if ($r1 = mysqli_fetch_assoc($SelectidMc)){
					echo "<font size='3' style='color:red'> &nbsp;&nbsp;&nbsp; Answer: </font>". $r1["answer"];
				}
        echo "</div>";
			}
    }
    
    if ($resultAnN->num_rows > 0) {
		while($rowMc = $resultAnN->fetch_assoc()){
	echo "<div class='AllQuestions'>";
			$s1=$rowMc["qid"];

			$idN = "select * from UserAnswersQuestionN where username='$n1' and qid='$s1'";
			$SelectidN = mysqli_query($conn,$idN);            
					   
			$temp1 = "select * from questionN where id='$s1'";
			$SelectQueryN = mysqli_query($conn,$temp1); 
			$array_question=array();
			
			echo"<br>";
			if ($r2 = mysqli_fetch_assoc($SelectQueryN)){
				echo "<div class='Mc_Text'> <b><font size='4'> &#9656; " . $r2["query"]. "</font></b> </div>";    
			}
			if ($r3 = mysqli_fetch_assoc($SelectidN)){
					echo "<font size='3' style='color:red'> &nbsp;&nbsp;&nbsp; Answer: </font> ". $r3["answer"];
			}
	echo "</div>";
		}
    }
    ?>
	
    <form method="post">
		<br>
		<b><font size="5" style="color:#ff3300"> &nbsp; Give student's Final Grade: </font></b> <input type="number" name="fgrade" min="1" max="10" required>
		<input type="submit" name="submit4" value="Save Grade"> 
    </form>
   
    <?php
		$fgrade = $_POST["fgrade"];
		//$_SESSION['writesTest'] = $fgrade;
		$final="update writesTest set finalGrade='$fgrade' where username='$n1' and test_title='$n2'";
		$UpdateGrade = mysqli_query($conn,$final);  
		
		if(isset($_POST['submit4'])){
			unset($_SESSION['writesTest']['username']);
			unset($_SESSION['writesTest']['test_title']);
			echo "<script> location.replace('ranktest.php'); </script>";
		}
    ?>

</body>
</html>