<?php session_save_path("sesiones");
session_start();

// Vacio las variables de sesión
if(!empty($_SESSION)){
	$_SESSION = array();
}
session_unset();
session_destroy();
$root = '';

// Incluyo el template engine
include('includes/templateEngine.inc.php');

// Cargo la plantilla
$twig->display('conexionCaida.html');

?>