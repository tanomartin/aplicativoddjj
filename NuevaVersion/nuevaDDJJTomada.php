<?php session_save_path("sesiones");
	session_start();
	$root = '';
	include('lib/php/verificaSesion.php');
	include('lib/php/verificaConexion.php');
	include('lib/php/funciones.php');
	
	// Incluyo el template engine
	include('includes/templateEngine.inc.php');
	$nrcont = $_GET['control'];
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
			$activos[$i] = array('nrcuil' => $nrcuil, 'apeynombre' => $apeynombre, 'tipoydoc' => $tipoydoc, 'remune' => 0);
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
			$baja[$i] = array('nrcuil' => $nrcuil, 'apeynombre' => $apeynombre, 'tipoydoc' => $tipoydoc, 'motivo' => '');
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
    	$sentencia->bind_result($anio, $mes, $relacion, $tipo, $valor, $retiene060, $retiene100, $retiene150, $mensaje);
		$i = 0;
		while ($sentencia->fetch()) {
			$extraordinarios[$i] = array('anio' => $anio, 'mes' => $mes, 'tipo' => $tipo, 'valor' => $valor, 'retiene060' => $retiene060, 'retiene100' => $retiene100, 'retiene150' => $retiene150, 'mensaje' => $mensaje);
			$i = $i + 1;
    	}
	}

	$consultaDDJJTotal = "SELECT 
	nrcuil,
	permes,
	perano,
	remune,
	apo060,
	apo100,
	apo150,
	totapo,
	recarg,
	observ 
	FROM validas
	WHERE 
	nrcuit = $nrcuit and 
	nrctrl = $nrcont and 
	nrcuil = 99999999999";
	//print($consultaDDJJTotal);print("<br>");
	$respuesta = $mysqli -> query($consultaDDJJTotal);
	$ddjjTotalData = $respuesta -> fetch_assoc();
	
	$consultaDDJJ = "SELECT 
	ppjj.nrcuil,empleados.nombre,empleados.apelli,empleados.tipdoc,empleados.nrodoc,ppjj.remune,ppjj.apo060,ppjj.apo100,ppjj.apo150
	FROM ppjj, empleados
	WHERE 
	ppjj.nrcuit = $nrcuit and 
	ppjj.nrctrl = $nrcont and 
	ppjj.nrcuil != 99999999999 and
	ppjj.nrcuil = empleados.nrcuil and
	ppjj.nrcuit = empleados.nrcuit 
	ORDER BY ppjj.nrcuil";
	//print($consultaDDJJ);print("<br>");
	
	$ppjj = array();
	if ($sentencia = $mysqli->prepare($consultaDDJJ)) {
    	$sentencia->execute();
    	$sentencia->bind_result($nrcuil, $nombre, $apelli, $tipdoc, $nrodoc, $remune, $apo060, $apo100, $apo150);
		$i = 0;
		while ($sentencia->fetch()) {
			$apeynombre = $apelli.", ".$nombre;
			$tipoydoc = $tipdoc.": ".$nrodoc;
			$ppjj[$i] = array('nrcuil' => $nrcuil, 'apeynombre' => $apeynombre, 'tipoydoc' => $tipoydoc, 'remune' => $remune, 'apo060' => $apo060, 'apo100' => $apo100, 'apo150' => $apo150);
			$i = $i + 1;
    	}
	}
	
	//recoorro los activos y le pego la remu si es que existe en la ddjj que quiero absorver
	for ($i=0; $i < sizeof($activos); $i++) {
		for ($j=0; $j < sizeof($ppjj); $j++) {
			if ($activos[$i]['nrcuil'] == $ppjj[$j]['nrcuil'] ) {
				$activos[$i]['remune'] = $ppjj[$j]['remune'];
			}
		}
	}
	
	//recoorro los de baja y le pego la remu en el motivo si es que existe en la ddjj que quiero absorver
	for ($i=0; $i < sizeof($baja); $i++) {
		for ($j=0; $j < sizeof($ppjj); $j++) {
			if ($baja[$i]['nrcuil'] == $ppjj[$j]['nrcuil'] ) {
				$baja[$i]['motivo'] = "REMUNERACION EN DDJJ TOMADA: ".$ppjj[$j]['remune'];
			}
		}
	}
	
	$miniAutori = array();
	$consultaMinimo = "SELECT count(*) as autorizado FROM empresassinminimo where nrcuit = $nrcuit and autori = 1";
	if ($sentencia = $mysqli->prepare($consultaMinimo)) {   
		$respMinimo = $mysqli -> query($consultaMinimo);
		$miniAutori = $respMinimo -> fetch_assoc();
		if ($miniAutori['autorizado']  == 0) $minimo = 0;
		if ($miniAutori['autorizado']  == 1) $minimo = 1;
	}
	
	//print("ACTIVOS<br>");
	//var_dump($activos);
	//print("BAJA<br>");
	//var_dump($baja);
	//print("DETALLE<br>");
	//var_dump($ppjj);
	//print("TOTALES<br>");
	//var_dump($ddjjTotalData);
	
	// Cargo la plantilla
	$twig->display('nuevaDDJJTomada.html',array("userName" => $_SESSION['userNombre'], "userID" => $_SESSION['userID'], "activos" => $activos, "baja" => $baja, "anios"=> $anios, 'meses' => $meses, 'permes' => $ddjjTotalData['permes'], 'perano' => $ddjjTotalData['perano'], 'minimoAutorizado' => $minimo));

?>