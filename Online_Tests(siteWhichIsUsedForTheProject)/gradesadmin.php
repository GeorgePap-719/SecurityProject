<?php 
	session_start();
	if(isset($_SESSION['user']) && strcmp($_SESSION['user'],"admin") == 0){
		$n=$_SESSION['user'];
		echo "<span id='hello'> <br> &#160; User: $n </span> <br>";
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
	
    $gr="select * from writesTest";
    $resGrade = $conn->query($gr);  
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="gradescss.css">
    <title>Grades</title>
</head>

<body class="main">
	<button onclick="location.href='page2admin.php';" class="goback"></button>
    <button onclick="location.href='logout.php';" class="logoutb"></button>
    
    <?php
    if ($resGrade->num_rows > 0) {
		while($r = $resGrade->fetch_assoc()){
	echo "<div class='AllQuestions'>";
			if($r["finalGrade"]==!NULL){
				echo "<div class='Mc_Text'> <b><font size='5'> &#9656; "." Username: ". $r["username"]."<br> &nbsp; &#8226; Test title: ".$r["test_title"]."<br> &nbsp; &#8226; Grade: ".$r["finalGrade"]."/10". "</font></b> </div><br>";  
            }
			else{
				echo "<div class='Mc_Text' style='color:red'> <b><font size='5'> &#9656; "." Username: ". $r["username"]."<br> &nbsp; &#8226; Test title: ".$r["test_title"]."<br> &nbsp; &#8226; Grade not submitted". "</font></b> </div><br>";  
            }
    echo "</div>";   
            }//telos while
    }//telos if 
    ?>  
</body>
</html>
