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
   
        
        $st="select * from writesTest";
        $staTests = $conn->query($st);  
        
        
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="statisticscss.css">
    <title>Statistics</title>
</head>

<body class="main">
	<button onclick="location.href='page2admin.php';" class="goback"></button>
        <button onclick="location.href='logout.php';" class="logoutb"></button>
    
    
    <?php
    
    $a=0.0;
    $b=0.0;
    $c=0.0;
	$d=0.0;
    $e=0.0;
    
    if ($staTests->num_rows > 0) {
            while($Rst = $staTests->fetch_assoc()){
                 $e++;
                 if($Rst["finalGrade"]>=0 && $Rst["finalGrade"]<=3 && $Rst["finalGrade"]!=NULL) $a++;
                 else if($Rst["finalGrade"]>3 && $Rst["finalGrade"]<=6 && $Rst["finalGrade"]!=NULL)   $b++;
                 else if($Rst["finalGrade"]>6 && $Rst["finalGrade"]<=10 && $Rst["finalGrade"]!=NULL) $c++;
                 else if($Rst["finalGrade"]==NULL) $e--;
            }
    }
    
    $resultA=($a/$e)*100;
    $resultB=($b/$e)*100;
    $resultC=($c/$e)*100;
    $resultD=($d/$e)*100;
    
    $resultAstring = number_format($resultA, 2);
    $resultBstring = number_format($resultB, 2);
    $resultCstring = number_format($resultC, 2);
    $resultDstring = number_format($resultD, 2);
     echo  "<br>";     
    echo "<b><font size='5'>&nbsp; Percentage of students with grade in the range of 0-3: ". $resultAstring . "%</b><br>";
    echo "<b><font size='5'>&nbsp; Percentage of students with grade in the range of 4-6: ". $resultBstring . "%</b><br>";
    echo "<b><font size='5'>&nbsp; Percentage of students with grade in the range of 7-10: ". $resultCstring . "%</b><br>";      
    ?>
    
    
    
    
        
</body>
</html>
