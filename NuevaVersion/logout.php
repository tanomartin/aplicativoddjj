<?php session_save_path("sesiones");
session_start();

// Vacio las variables de sesión
if(!empty($_SESSION)){
	$_SESSION = array();
	session_destroy();
}

header("Location:index.php");
?>