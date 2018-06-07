<?php
	//Se inicia la sesión
	session_start();
	//Se establecen las variables de sesión
	$_SESSION['usuario']=$_POST['usuario'];
	$_SESSION['password']=$_POST['password'];
	//Se incluyen las funciones necesarias
	include_once ('funciones.php');
	if (es_usuario($_SESSION['usuario'],$_SESSION['password'])){
	//Si el usuario es un usuario registrado
		$priv = get_idusuario($_SESSION['usuario']);
		$perfil = get_perfil($_SESSION['usuario']);
		$_SESSION['perfil'] = $perfil;
		$_SESSION['privi'] = $priv;
		$_SESSION['provincias'] = get_provincias($priv);
		header("Location: ../index.php");
	}
	else{
		header("Location: ../index.php");
	}
?>