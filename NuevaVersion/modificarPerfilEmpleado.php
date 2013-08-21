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
	
	$consulta = "SELECT * FROM empresa WHERE nrcuit=$cuit";
	$respuesta = $mysqli -> query($consulta);
	$empresaData = $respuesta -> fetch_assoc();
	//echo $consulta; echo "<br>";
	
	$consulta = "SELECT * FROM empleados WHERE nrcuit = $cuit and nrcuil = $cuil";
	$respuesta = $mysqli -> query($consulta);
	$empleadoData = $respuesta -> fetch_assoc();
	//echo $consulta; echo "<br>";
	
	$empleado = (object) array('cuil' => $empleadoData['nrcuil'], 'apellido' => $empleadoData['apelli'], 'nombre' => $empleadoData['nombre'], 'fecingreso' => invertirFecha($empleadoData['fecing']), 'tipdoc' => $empleadoData['tipdoc'], 'nrodoc' => $empleadoData['nrodoc'],  'sexo' => $empleadoData['ssexxo'], 'fecnac' => invertirFecha($empleadoData['fecnac']), 'estado' => $empleadoData['estciv'], 'direccion' => $empleadoData['direcc'], 'localidad' => $empleadoData['locale'], 'codpos' => $empleadoData['copole'], 'provin' => $empleadoData['provin'], 'nacion' => $empleadoData['nacion'], 'categoria' => $empleadoData['catego'], 'activo' => $empleadoData['activo']);
	
	//var_dump($empleado);
	
	$consulta = "SELECT * FROM provincia";
	if ($sentencia = $mysqli->prepare($consulta)) {
    	$sentencia->execute();
    	$sentencia->bind_result($codigo, $descri);
		$i = 1;
		$provincias[0] = array('codigo' => NULL, 'descripcion' => "Seleccionar Provincia");
		while ($sentencia->fetch()) {
			$provincias[$i] = array('codigo' => $codigo, 'descripcion' => $descri);
			$i = $i + 1;
    	}
	}
	
	//var_dump($provincias);
	
	$codram = $empresaData['rramaa'];
	$consulta = "SELECT codcat, descri FROM categorias where codram = $codram";
	//echo $consulta;
	if ($sentencia = $mysqli->prepare($consulta)) {
    	$sentencia->execute();
    	$sentencia->bind_result($codigo, $descri);
		$i = 1;
		$categorias[0] = array('codigo' => NULL, 'descripcion' => "Seleccionar Categoria");
		while ($sentencia->fetch()) {
			$categorias[$i] = array('codigo' => $codigo, 'descripcion' => $descri);
			$i = $i + 1;
    	}
	}
		
	//var_dump($categorias);
		
	// Cargo la plantilla
	$twig->display('modificarPerfilEmpleado.html',array("userName" => $_SESSION['userNombre'], "empleado" => $empleado, "provincias" => $provincias, "categorias" => $categorias));


?>