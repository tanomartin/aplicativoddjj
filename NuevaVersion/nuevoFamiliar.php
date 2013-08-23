<?php session_save_path("sesiones");
session_start();
	include('lib/php/verificaSesion.php');
	include('lib/php/verificaConexion.php');
	include('lib/php/funciones.php');
	$root = '';

	// Incluyo el template engine
	include('includes/templateEngine.inc.php');
	
	$cuit = $_SESSION['userCuit'];
	$cuil = $_GET['cuil'];
	
	$consulta = "SELECT * FROM empleados WHERE nrcuil = $cuil and nrcuit = $cuit";
	$respuesta = $mysqli -> query($consulta);
	$titularData = $respuesta -> fetch_assoc();
	$titular = (object) array('cuil' =>  $titularData['nrcuil'], 'apellido' => $titularData['apelli'], 'nombre' => $titularData['nombre']);	

	$parentescos = getParentescos();
	//var_dump($parentescos);
	$tiposDocu = getTipoDocu();

	// Cargo la plantilla
	$twig->display('nuevoFamiliar.html',array("userName" => $_SESSION['userNombre'], "titular" => $titular, "parentescos" => $parentescos, "tiposDocu" => $tiposDocu));

?>