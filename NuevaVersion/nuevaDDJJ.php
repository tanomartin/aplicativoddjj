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
	
	$consultaAnio = "SELECT * FROM anios order by anio DESC";
	if ($sentencia = $mysqli->prepare($consultaAnio)) {
    	$sentencia->execute();
    	$sentencia->bind_result($anio);
		$anios[0] = array('codigo' => NULL, 'anio' => "Seleccionar");
		$i = 1;
		while ($sentencia->fetch()) {
			$anios[$i] = array('codigo' => $anio, 'anio' => $anio);
			$i = $i + 1;
    	}
	}
	
	$consultaMes = "SELECT * FROM periodos order by mes ASC";
	if ($sentencia = $mysqli->prepare($consultaMes)) {
    	$sentencia->execute();
    	$sentencia->bind_result($anio, $mes, $descrip);
		$i = 0;
		while ($sentencia->fetch()) {
			$meses[$i] = array('anio' => $anio, 'mes' => $mes, 'descrip' => $descrip);
			$i = $i + 1;
    	}
	}
	
	$consultaExtra = "SELECT * FROM extraordinarios";
	if ($sentencia = $mysqli->prepare($consultaExtra)) {
    	$sentencia->execute();
    	$sentencia->bind_result($anio, $mes, $relacion, $tipo, $valor, $retiene060, $retiene100, $retiene150);
		$i = 0;
		while ($sentencia->fetch()) {
			$extraordinarios[$i] = array('anio' => $anio, 'mes' => $mes, 'tipo' => $tipo, 'valor' => $valor, 'retiene060' => $retiene060, 'retiene100' => $retiene100, 'retiene150' => $retiene150);
			$i = $i + 1;
    	}
	}

	// Cargo la plantilla
	$twig->display('nuevaDDJJ.html',array("userName" => $_SESSION['userNombre'], "userID" => $_SESSION['userID'], "empleadosActivos" => $activos, "empleadosBaja" => $baja, "anios"=> $anios, 'meses' => $meses. 'extra' => $extraordinarios));

?>