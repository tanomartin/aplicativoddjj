<?php session_save_path("sesiones");
	session_start();
	$root = '';
	include('lib/php/verificaSesion.php');
	include('lib/php/verificaConexion.php');
	include('lib/php/funciones.php');
	
	// Incluyo el template engine
	include('includes/templateEngine.inc.php');
	
	$nrcuit = $_SESSION['userCuit'];
	$consultaActivos = "SELECT nrcuil, apelli, nombre, tipdoc, nrodoc FROM empleados where nrcuit = $nrcuit and activo = 'SI' order by nrcuil";
	$activos = array();
	if ($sentencia = $mysqli->prepare($consultaActivos)) {
    	$sentencia->execute();
    	$sentencia->bind_result($nrcuil, $apellido, $nombre, $tipdoc, $nrdoc);
		$i = 0;
		while ($sentencia->fetch()) {
			$apeynombre = $apellido.", ".$nombre;
			$tipoydoc = $tipdoc.": ".$nrdoc;
			$activos[$i] = array('nrcuil' => $nrcuil, 'apeynombre' => $apeynombre, 'tipoydoc' => $tipoydoc);
			$i = $i + 1;
    	}
	}

	$consultaBaja = "SELECT nrcuil, apelli, nombre, tipdoc, nrodoc FROM empleados where nrcuit = $nrcuit and activo = 'NO' order by nrcuil";
	$baja = array();
	if ($sentencia = $mysqli->prepare($consultaBaja)) {
    	$sentencia->execute();
    	$sentencia->bind_result($nrcuil, $apellido, $nombre, $tipdoc, $nrdoc);
		$i = 0;
		while ($sentencia->fetch()) {
			$apeynombre = $apellido.", ".$nombre;
			$tipoydoc = $tipdoc.": ".$nrdoc;
			$baja[$i] = array('nrcuil' => $nrcuil, 'apeynombre' => $apeynombre, 'tipoydoc' => $tipoydoc);
			$i = $i + 1;
    	}
	}
	
	// Cargo la plantilla
	$twig->display('listaEmpleados.html',array("userName" => $_SESSION['userNombre'], "userID" => $_SESSION['userID'], "empleadosActivos" => $activos, "empleadosBaja" => $baja));

?>