<?php session_save_path("sesiones");
session_start();

	include('lib/php/verificaSesion.php');
	include('lib/php/verificaConexion.php');
	include('lib/php/verificaMgr.php');
	$root = '';
	// Incluyo el template engine
	include('includes/templateEngine.inc.php');
	
	// Cargo la plantilla
	$twig->display('cargaArchivoFam.html',array("noleidos" => $_SESSION['noleidos'], "userName" => $_SESSION['userNombre']));

?>