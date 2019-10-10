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
	
	$stname="";
    $sdtest="";
	$allWt = "select * from writesTest where finalGrade IS NULL ";
    $resultWt = $conn->query($allWt);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="wwwcss.css">
    <title>www</title>
</head>

<body class="main">
    <button onclick="location.href='wwwadmin.php';" class="goback"></button>
    <button onclick="location.href='logout.php';" class="logoutb"></button>
    <br>
    <h2> &nbsp;&nbsp;&#9656; Available tests for rank: </h2>
    
	<?php
		if ($resultWt->num_rows > 0) {
			// output data of each row
			while($rowWt = $resultWt->fetch_assoc()) {
    ?> 
    <div class="testLinks"> <font size="5"> &nbsp;&nbsp;&nbsp;&nbsp;&#8226; <?php echo "Student name: ".$rowWt["username"]." <br>&nbsp;&nbsp;&nbsp; Test title: ".$rowWt["test_title"] ?> </font> </div> <br> <!-- display test titles -->
    <?php         
            } // telos while
        }//telos if
        else{
            echo "No results";
        }
    ?>
    <form method="post">
		<b><font size="5"> &nbsp; Give student's name: </font></b> <input type="text" name="stname" placeholder="Same way it is displayed.." maxlength='30'required>
		<b><font size="5"> <br> &nbsp; Give test's title: </font></b> <input type="text" name="sdtest" placeholder="Same way it is displayed.." maxlength='30'required>
		<input type="submit" name="submit3" value="Rank Test"> 
    </form>

	<?php
		$stname=$_POST["stname"];

		$sdtest=$_POST["sdtest"];
	   //echo $stname;
	   //echo $sdtest;
	   
		$res = mysqli_query($conn,"select * from writesTest");
		if($row = mysqli_fetch_row($res)){
			$_SESSION['writesTest'] = array();
			
			$row['username']=$stname;
			$row['test_title']=$sdtest;
			
			$_SESSION['writesTest']['username']=$row['username'];
			$_SESSION['writesTest']['test_title']=$row['test_title'];
		}           
		if(strcmp($stname,"")!= 0) {
			if (strcmp($sdtest,"")!= 0){
				echo "<script> location.replace('ranktestContinue.php'); </script>";
			}
		}
	?>    
</body>
</html>