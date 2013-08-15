<?php session_save_path("sesiones");
session_start();

// Directorio Raíz de la app
// Es utilizado en templateEngine.inc.php
$root = '';
//echo $_SESSION['userNombre'];
if(!empty($_SESSION) && $_SESSION['userLogin'] == true){
	// Incluyo el template engine
	include('includes/templateEngine.inc.php');

	// Cargo la plantilla
	$twig->display('index.html', array("userName" => $_SESSION['userNombre'], "userID" => $_SESSION['userID']));
} else {
	header("Location:login.php");
}
?>