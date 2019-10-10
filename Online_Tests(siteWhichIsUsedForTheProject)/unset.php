<?php 
	session_start();
	if(isset($_SESSION['user']) && strcmp($_SESSION['user'],"admin") == 0){
		//unset to title test,test name ... wste na min mpei sto addMc xwris prin na xei ftiaksei new test!
		//menoun oi times apo to create test kathe fora, gi auto unset otan ginetai complete 1 test!
		unset($_SESSION['testTit']);
		unset($_SESSION['subName']);

		header('Location:page2admin.php');
	}
	else header('Location:phpIndex.php');
?>
