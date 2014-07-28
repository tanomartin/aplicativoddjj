<?php session_save_path("sesiones");
	session_start();
	$root = '';
	include('lib/php/verificaSesion.php');
	include('lib/php/verificaConexion.php');
	
	
	// Incluyo el template engine
	include('includes/templateEngine.inc.php');
	
	$nrcuit = $_SESSION['userCuit'];
	$nrcont = $_GET['control'];
		
	$consultaDDJJTotal = "SELECT 
	ddjj.nrcuil,
	ddjj.permes,
	periodos.descripcion,
	ddjj.perano,
	ddjj.remune,
	ddjj.apo060,
	ddjj.apo100,
	ddjj.apo150,
	ddjj.totapo,
	ddjj.recarg,
	ddjj.observ 
	FROM ddjj, periodos
	WHERE 
	ddjj.nrcuit = $nrcuit and 
	ddjj.nrctrl = $nrcont and 
	ddjj.nrcuil = 99999999999 and
	ddjj.perano = periodos.anio and
	ddjj.permes = periodos.mes";
	//print($consultaDDJJTotal);print("<br>");
	$ddjjTotalData = array();
	$respuesta = $mysqli -> query($consultaDDJJTotal);
	$ddjjTotalData = $respuesta -> fetch_assoc();
	
	$consultaDDJJ = "SELECT 
	ddjj.nrcuil,empleados.nombre,empleados.apelli,empleados.tipdoc,empleados.nrodoc,ddjj.remune,ddjj.apo060,ddjj.apo100,ddjj.apo150,ddjj.totapo,ddjj.recarg,ddjj.observ 
	FROM ddjj, empleados
	WHERE 
	ddjj.nrcuit = $nrcuit and 
	ddjj.nrctrl = $nrcont and 
	ddjj.nrcuil != 99999999999 and
	ddjj.nrcuil = empleados.nrcuil and
	ddjj.nrcuit = empleados.nrcuit 
	ORDER BY ddjj.nrcuil";
	//print($consultaDDJJ);print("<br>");
	
	$ddjj = array();
	if ($sentencia = $mysqli->prepare($consultaDDJJ)) {
    	$sentencia->execute();
    	$sentencia->bind_result($nrcuil, $nombre, $apelli, $tipdoc, $nrodoc, $remune, $apo060, $apo100, $apo150, $totapo, $recarg, $observ);
		$i = 0;
		while ($sentencia->fetch()) {
			$apeynombre = $apelli.", ".$nombre;
			$tipoydoc = $tipdoc.": ".$nrodoc;
			$ddjj[$i] = array('nrcuil' => $nrcuil, 'apeynombre' => $apeynombre, 'tipoydoc' => $tipoydoc, 'remune' => $remune, 'apo060' => $apo060, 'apo100' => $apo100, 'apo150' => $apo150, 'totapo' => $totapo, 'recarg' => $recarg, 'observ' => $observ);
			$i = $i + 1;
    	}
	}
	
	$consultaDDJJInactivos = "SELECT 
	inactivos.nrcuil,empleados.nombre,empleados.apelli,empleados.tipdoc,empleados.nrodoc,inactivos.permes,inactivos.perano,inactivos.motivo 
	FROM inactivos, empleados
	WHERE 
	inactivos.nrcuit = $nrcuit and 
	inactivos.nrctrl = $nrcont and
	inactivos.nrcuil = empleados.nrcuil and
	inactivos.nrcuit = empleados.nrcuit 
	ORDER BY inactivos.nrcuil";
	
	$ddjjinactivos = array();
	if ($sentencia = $mysqli->prepare($consultaDDJJInactivos)) {
    	$sentencia->execute();
    	$sentencia->bind_result($nrcuil, $nombre, $apelli, $tipdoc, $nrodoc, $permes, $perano, $motivo);
		$i = 0;
		while ($sentencia->fetch()) {
			$apeynombre = $apelli.", ".$nombre;
			$tipoydoc = $tipdoc.": ".$nrodoc;
			$ddjjinactivos[$i] = array('nrcuil' => $nrcuil, 'apeynombre' => $apeynombre, 'tipoydoc' => $tipoydoc, 'motivo' => $motivo);
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
	
	$miniAutori = array();
	$consultaMinimo = "SELECT count(*) as autorizado FROM empresassinminimo where nrcuit = $nrcuit and autori = 1";
	if ($sentencia = $mysqli->prepare($consultaMinimo)) {   
		$respMinimo = $mysqli -> query($consultaMinimo);
		$miniAutori = $respMinimo -> fetch_assoc();
		if ($miniAutori['autorizado']  == 0) $minimo = 0;
		if ($miniAutori['autorizado']  == 1) $minimo = 1;
	}
	
	//var_dump($ddjjTotalData);
	//var_dump($ddjj);
	//var_dump($ddjjinactivos);
	//var_dump($extraordinarios);
	
	// Cargo la plantilla
	$twig->display('editarDDJJ.html',array("userName" => $_SESSION['userNombre'], "userID" => $_SESSION['userID'], "ddjj" => $ddjj, "ddjjinactivos" => $ddjjinactivos, "total" => $ddjjTotalData, 'extraordinario' => $extraordinarios, 'minimoAutorizado' => $minimo));

?>