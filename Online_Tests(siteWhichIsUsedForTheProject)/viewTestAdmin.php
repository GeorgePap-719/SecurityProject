<?php                 
    session_start();
	if( isset($_SESSION['user']) && isset($_SESSION['test']) && strcmp($_SESSION['user'],"admin") == 0  ){
		$n=$_SESSION['user'];
        $t=$_SESSION['test'];        
		echo "<span id='hello'> <br> &#160; User: $n <br> &#160; Test title: $t </span> <br>";

		$serverName = "localhost";
		$userName = "root";
		$password = "";
		$db = "2249802_tests";   
		$conn = mysqli_connect($serverName,$userName,$password,$db);                
		if(!$conn){
			echo "Sorry,an error occurred. Please try again!"; //db error connection
			die();                                
		}                                
    
		$qMc = "select qid from questionMcbelongsTest where testTit='$t'";
		$resultMc = $conn->query($qMc);    
		
		$qN = "select qid from questionNbelongsTest where testTit='$t'";
		$resultN = $conn->query($qN); 
	}
	else{
		header('Location:phpIndex.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="testscss.css">   
</head>
<body class="main"> 
	<button onclick="location.href='page2admin.php';" class="goback"></button>
    <button onclick="location.href='logout.php';" class="logoutb"></button>
	<br>

    <?php
	
	$i=0;
	/*Load multiple choice questions*/
    if ($resultMc->num_rows > 0) {
		//output data of each row
		
		while($rowMc = $resultMc->fetch_assoc()){
			echo "<div class='AllQuestions'>";
			$s=$rowMc["qid"];
					   
			$temp0 = "select * from questionMc where id='$s'";
			$SelectQuery = mysqli_query($conn,$temp0);	
			$array_question=array();
			
			if ($r0 = mysqli_fetch_assoc($SelectQuery)){
				$c1 = $r0["choice1"];
				$c2 = $r0["choice2"];
				$c3 = $r0["choice3"];
				$c4 = $r0["choice4"];
				
				echo "<div class='Mc_Text'> <b><font size='5'> &#9656; " . $r0["query"]. "</font></b> </div><br>";
				echo "<input name='option[$i]' type='radio' value='$c1'>" . $r0["choice1"] ."</input>";
				echo "<input name='option[$i]' type='radio' value='$c2'>" . $r0["choice2"] ."</input><br>";
				echo "<input name='option[$i]' type='radio' value='$c3'>" . $r0["choice3"] ."</input>";
				echo "<input name='option[$i]' type='radio' value='$c4'>" . $r0["choice4"] ."</input>";	
				echo "<input type='hidden' name='mc_id[]' value='$s' ";
				
				$i++;
			}
			echo "</div>";
		}

	} 

	/*Load normal-growth questions*/
    if ($resultN->num_rows > 0) {

		while($rowN = $resultN->fetch_assoc()){
			echo "<div class='AllQuestions'>";
			$s1=$rowN["qid"];

			$temp1 = "select * from questionN where id='$s1'";
			$SelectQueryN = mysqli_query($conn,$temp1);
				
			if ($r1 = mysqli_fetch_assoc($SelectQueryN)){
				echo "<div class='N_Text'> <b><font size='5'> &#9656; ".$r1["query"]."</font></b> </div>";
				echo "<textarea class='Mc_Text' name='answers[]' placeholder='Here you can write your answer!' rows='10' cols='100' maxlength='500'></textarea>";
				echo "<input type='hidden' name='gr_id[]' value='$s1' ";
			}
			echo "</div>";
		}

	}
	?>

 
</body>
</html>