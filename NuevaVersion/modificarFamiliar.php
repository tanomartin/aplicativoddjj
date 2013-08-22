<?php session_save_path("sesiones");
session_start();
	include('lib/php/verificaSesion.php');
	include('lib/php/verificaConexion.php');
	include('lib/php/funciones.php');
	$root = '';

	// Incluyo el template engine
	include('includes/templateEngine.inc.php');
	
	$cuit = $_SESSION['userCuit'];
	$id = $_GET['id'];
	$cuil = $_GET['cuil'];
	$codpar = $_GET['codpar'];
	
	$consulta = "SELECT * FROM empleados WHERE nrcuil = $cuil and nrcuit = $cuit";
	//echo $consulta;
	$respuesta = $mysqli -> query($consulta);
	$titularData = $respuesta -> fetch_assoc();
	$titular = (object) array('apellido' => $titularData['apelli'], 'nombre' => $titularData['nombre']);
	
	
	$consulta = "SELECT * FROM familia WHERE nrcuil = $cuil and id = $id and codpar = '$codpar'";
	//echo $consulta;
	$respuesta = $mysqli -> query($consulta);
	$familiaData = $respuesta -> fetch_assoc();
	//echo $consulta; echo "<br>";
	
	$familiar = (object) array('id' => $familiaData['id'], 'cuil' => $familiaData['nrcuil'], 'nombre' => $familiaData['nombre'], 'apellido' => $familiaData['apelli'], 'codpar' => $familiaData['codpar'], 'sexo' => $familiaData['ssexxo'], 'fecnac' => invertirFecha($familiaData['fecnac']), 'fecing' => invertirFecha($familiaData['fecing']), 'tipdoc' => $familiaData['tipdoc'], 'nrodoc' => $familiaData['nrodoc'], 'benefi' =>  $familiaData['benefi']);
	
	//var_dump($familiar);
	
	$parentescos = getParentescos();
	// Cargo la plantilla
	$twig->display('modificarFamiliar.html',array("userName" => $_SESSION['userNombre'], "familiar" => $familiar, "titular" => $titular, "parentescos" => $parentescos));


?>