<?php
	session_start(); 
	if(isset($_SESSION['user'])){
	session_destroy();
	//session unset();
	}
	header('Location:phpIndex.php');
?>