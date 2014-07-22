<?php session_save_path("sesiones");
	session_start();
	$root = '';
	include('lib/php/verificaSesion.php');
	include('lib/php/verificaConexion.php');
	include('lib/php/funciones.php');

	// Incluyo el template engine
	include('includes/templateEngine.inc.php');
	
	$cuit = $_SESSION['userCuit'];
	$consulta = "SELECT * FROM empresa WHERE nrcuit=$cuit";
	$respuesta = $mysqli -> query($consulta);
	$empresaData = $respuesta -> fetch_assoc();
	//echo $consulta; echo "<br>";
	
	$cuil = $_GET['cuil'];
	$consulta = "SELECT * FROM empleados WHERE nrcuit = $cuit and nrcuil = $cuil";
	//echo $consulta; echo "<br>";
	$respuesta = $mysqli -> query($consulta);
	$empleadoData = $respuesta -> fetch_assoc();
	
	$idCatego = $empleadoData['catego'];
	$idRama = $empresaData['rramaa'];
	$consCate = "SELECT * FROM categorias WHERE codram = $idRama and codcat = $idCatego";
	//echo $consCate; echo "<br>";
	$respCate = $mysqli -> query($consCate);
	$cateData = $respCate -> fetch_assoc();
	
	$idProvin = $empleadoData['provin'];
	$consProvin = "SELECT * FROM provincia WHERE id = $idProvin";
	$respProvin = $mysqli -> query($consProvin);
	$provinData = $respProvin -> fetch_assoc();

	
	$empleado = (object) array('cuil' => $empleadoData['nrcuil'], 'apellido' => $empleadoData['apelli'], 'nombre' => $empleadoData['nombre'], 'fecingreso' => invertirFecha($empleadoData['fecing']), 'tipdoc' => $empleadoData['tipdoc'], 'nrodoc' => $empleadoData['nrodoc'],  'sexo' => $empleadoData['ssexxo'], 'fecnac' => invertirFecha($empleadoData['fecnac']), 'estado' => $empleadoData['estciv'], 'direccion' => $empleadoData['direcc'], 'localidad' => $empleadoData['locale'], 'codpos' => $empleadoData['copole'], 'provin' => $provinData['descripcion'], 'nacion' => $empleadoData['nacion'], 'categoria' => $cateData['descri'], 'activo' => $empleadoData['activo']);
 
 	//var_dump($empleado);
	
	$consultaFamilia = "SELECT id, nrcuil, nombre, apelli, codpar, ssexxo, fecnac, fecing, tipdoc, nrodoc, benefi FROM familia where nrcuit = $cuit and nrcuil = $cuil";
	//echo $consultaFamilia;
	$familiares = array();
	if ($sentencia = $mysqli->prepare($consultaFamilia)) {
    	$sentencia->execute();
    	$sentencia->bind_result($id, $nrcuil, $nombre, $apellido, $parente, $sexo, $fecnac, $fecing, $tipdoc, $nrdoc, $benefi);
		$i = 0;
		while ($sentencia->fetch()) {
			$apeynombre = $apellido.", ".$nombre;
			$tipoydoc = $tipdoc.": ".$nrdoc;
			$familiares[$i] = array('id' => $id, 'cuil' => $nrcuil, 'apeynombre' => $apeynombre, 'tipoydoc' => $tipoydoc, 'parentesco' => $parente ,'sexo' => $sexo, 'fecnac' => invertirFecha($fecnac), 'fecing' => invertirFecha($fecing), 'benefi' => $benefi);
			$i = $i + 1;
    	}
	}
 
	//var_dump($familia);

	// Cargo la plantilla
	$twig->display('perfilEmpleado.html',array("userName" => $_SESSION['userNombre'], "empleado" => $empleado, "familiares" => $familiares ));


?>