<?php
	session_start();
	unset($_SESSION['usuario']); 
	unset($_SESSION['password']);
	header("Location: ../index.php");
	exit;
?>