<?php session_save_path("sesiones");
	session_start();
	$root = '';
	include('lib/php/verificaSesion.php');
	include('lib/php/verificaConexion.php');
	
	// Incluyo el template engine
	include('includes/templateEngine.inc.php');
	
		
	// Cargo la plantilla
	$twig->display('cambioContrasenia.html',array("noleidos" => $_SESSION['noleidos'], "userName" => $_SESSION['userNombre'], "userID" => $_SESSION['userID']));
?>