<?php session_save_path("sesiones");
session_start();

	include('lib/php/verificaSesion.php');
	include('lib/php/verificaConexion.php');
	$root = '';
	// Incluyo el template engine
	include('includes/templateEngine.inc.php');
	
	// Cargo la plantilla
	$twig->display('cargaArchivoDj.html',array("userName" => $_SESSION['userNombre']));

?>