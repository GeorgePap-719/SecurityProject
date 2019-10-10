<?php 
	session_start();
	if(isset($_SESSION['user'])){
		$n=$_SESSION['user'];
		echo "<span id='hello'> <br> &#160; Hello, $n! </span> <br>";
	}
	else{
		header('Location:phpIndex.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="page2css.css">
        <link rel="stylesheet" type="text/css" href="boxesStyle.css">
        <script src="boxesMove.js"></script>
	<title>Home</title>
</head>

<body class="main">
    <button onclick="location.href='logout.php';" class="logoutb"></button>
	<button onclick="location.href='changePassword.php';">Change Password</button>
	
	<ul id="menu">
		<li><a href="javascript:void(0)" class="tablinks" onclick="myFunction(event,'Home')" id="defaultOpen" >Home</a></li>
		<li><a href="javascript:void(0)" class="tablinks" onclick="myFunction(event,'About us')" >About us</a></li>
		<li><a href="javascript:void(0)" class="tablinks" onclick="myFunction(event,'Staff')" >Staff</a></li>
		<li class="dropdown">
			<a href="javascript:void(0)" class="dropbtn" >Subjects</a>
			<div class="dropdown-content">
				<a href="www.php" class="tablinks">www</a>
			</div>
		</li>
		<li><a href="grades.php" class="tablinks">Grades</a></li>
		<li><a href="statistics.php" class="tablinks" >Statistics</a></li>
		<li><a href="javascript:void(0)" class="tablinks" onclick="myFunction(event,'Contact us')">Contact us</a></li>
	</ul>
	
	<div id="Home" class="tabcontent">
		<div id="animate1" style="z-index: -1"><span class="text">You have to go to wholeheartedly into anything in order to achieve anything worth having <br><br> -Frank Floyed Wright</span></div>
        <div id="animate2" style="z-index: -1"><span class="text">Education is the most powerful weapon which you can use to change the world <br><br> -Nelson Mandela</span></div>
        <div id="animate3" ><span class="text">Education is not the learning of facts but the training of the mind <br><br> -Albert Einstein</span></div>
        <div id="animate4" ><span class="text">The beautiful thing about learning is that no one can take it away from you <br><br> -Unknown</span></div>
            <script>
                move13R();
                move24L();
            </script>
    </div>
	
    <div id="About us" class="tabcontent">
		<h1>About us!!</h1>
    </div>
    <div id="Staff" class="tabcontent">
		<h2>Academic Year 2016-2017 Professors of subject : www</h2>
        <h3>Antonis Dadaliaris</h3>
        <h3>Panagiotis Oikonomou</h3>
    </div>

    <div id="Contact us" class="tabcontent">
		<h1>Members</h1>
        <h2>Nikos Kaloritis - 2114151</h2>
        <h2>Panagiotis Viglas - 2114041</h2>
        <h2>Ioanna Kelemati - 2114230</h2>
        <h2>Giwrgos Papadopoulos - 2114077</h2>
    </div>
        
		
        <script>
        function myFunction(evt, tab) {       
			var i, tabcontent, tablinks;
            
            tabcontent = document.getElementsByClassName("tabcontent");
            
            for (i = 0; i < tabcontent.length; i++) {
				tabcontent[i].style.display = "none";
            }
			
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
			
            document.getElementById(tab).style.display = "block";
            evt.currentTarget.className += " active";
			document.title = tab;
        }
        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();
        </script>       
</body>
</html>
