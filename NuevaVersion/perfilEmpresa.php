<?php session_save_path("sesiones");
session_start();
include('lib/php/conexion.php');
// Directorio Raíz de la app
// Es utilizado en templateEngine.inc.php
$root = '';

if(!empty($_SESSION) && $_SESSION['userLogin'] == true){
	// Incluyo el template engine
	include('includes/templateEngine.inc.php');
	
	$cuit = $_SESSION['userCuit'];
	$consulta = "SELECT * FROM empresa WHERE nrcuit=$cuit";
	$respuesta = $mysqli -> query($consulta);
	$empresaData = $respuesta -> fetch_assoc();

	// Cargo la plantilla
	$twig->display('perfilEmpresa.html',array("userName" => $_SESSION['userNombre'], "cuit" => $_SESSION['userCuit'], "nombre" => $empresaData['nombre']));
}
else{
	header("Location:login.php");
}
?>