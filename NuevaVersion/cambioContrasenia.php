<?php session_save_path("sesiones");
	session_start();
	$root = '';
	include('lib/php/verificaSesion.php');
	include('lib/php/verificaConexion.php');
	include('lib/php/funciones.php');
	
	// Incluyo el template engine
	include('includes/templateEngine.inc.php');
	
		
	// Cargo la plantilla
	$twig->display('cambioContrasenia.html',array("userName" => $_SESSION['userNombre'], "userID" => $_SESSION['userID']));
?>