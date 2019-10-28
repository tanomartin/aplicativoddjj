<?php session_save_path("sesiones");
session_start();
	
	include('lib/php/verificaSesion.php');
	include('lib/php/verificaConexion.php');
	include('lib/php/verificaMgr.php');
	$root = '';
	// Incluyo el template engine
	include('includes/templateEngine.inc.php');

	
	$activos = array();
	$baja = array();
	$nrcuit=$_SESSION['userCuit'];
	$nombreArc=$_GET['nombre'];
	$permes=substr($nombreArc,15,2);
	$perano=substr($nombreArc,17,4);
	
	$archivoHost="modulog/archivos/$nrcuit/$nombreArc";
	//print($archivoHost); print("<br>");
	//print("MES: ".$permes); print("<br>");
	//print("ANIO: ".$perano); print("<br>");
	$registros = file($archivoHost, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	for($i = 0; $i < count($registros); $i++) {
		$campos=explode("|", $registros[$i]);
		//var_dump($campos);
		$nrcuil=$campos[1];
		$remune=(float)$campos[4];
		$archivo[$i] = array('nrcuil' => $nrcuil, 'remune' => $remune);
	}	
	//var_dump($archivo);
		
	$consultaActivos = "SELECT nrcuil, apelli, nombre, tipdoc, nrodoc FROM empleados where nrcuit = $nrcuit and activo = 'SI' order by nrcuil";
	if ($sentencia = $mysqli->prepare($consultaActivos)) {
    	$sentencia->execute();
    	$sentencia->bind_result($nrcuil, $apellido, $nombre, $tipdoc, $nrdoc);
		$i = 0;
		while ($sentencia->fetch()) {
			$apeynombre = $apellido.", ".$nombre;
			$tipoydoc = $tipdoc.": ".$nrdoc;
			$activos[$i] = array('nrcuil' => $nrcuil, 'apeynombre' => $apeynombre, 'tipoydoc' => $tipoydoc, 'remune' => 0);
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
	
	//recoorro los activos y le pego la remu si es que existe en el archivo
	for ($i=0; $i < sizeof($activos); $i++) {
		for ($j=0; $j < sizeof($archivo); $j++) {
			if ($activos[$i]['nrcuil'] == $archivo[$j]['nrcuil'] ) {
				$activos[$i]['remune'] = $archivo[$j]['remune'];
			}
		}
	}

	$consPeriodo = "SELECT * FROM periodos WHERE anio = $perano and mes = $permes";
	$respPeriodo = $mysqli -> query($consPeriodo);
	$periodoData = $respPeriodo -> fetch_assoc();
	
	$consultaExtra = "SELECT * FROM extraordinarios";
	if ($sentencia = $mysqli->prepare($consultaExtra)) {
    	$sentencia->execute();
    	$sentencia->bind_result($anio, $mes, $relacion, $tipo, $valor, $retiene060, $retiene100, $retiene150, $mensaje);
		$i = 0;
		while ($sentencia->fetch()) {
			$extraordinarios[$i] = array('anio' => $anio, 'mes' => $mes, 'tipo' => $tipo, 'valor' => $valor, 'retiene060' => $retiene060, 'retiene100' => $retiene100, 'retiene150' => $retiene150, 'mensaje' => $mensaje);
			$i = $i + 1;
    	}
	}
	
	//var_dump($activos);
	//var_dump($baja);
	$twig->display('nuevaDDJJGrande.html',array("noleidos" => $_SESSION['noleidos'], "userName" => $_SESSION['userNombre'], 'empleadosActivos' => $activos, 'empleadosBaja' => $baja, 'mesdesc' => $periodoData['descripcion'], 'permes' => $permes, 'perano' => $perano, 'extraordinario' => $extraordinarios));
	
?>
