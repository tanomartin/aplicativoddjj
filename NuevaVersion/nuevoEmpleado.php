<?php session_save_path("sesiones");
session_start();
	include('lib/php/verificaSesion.php');
	include('lib/php/verificaConexion.php');
	include('lib/php/funciones.php');
	$root = '';

	// Incluyo el template engine
	include('includes/templateEngine.inc.php');
	
		
	$cuit = $_SESSION['userCuit'];

	$consulta = "SELECT * FROM empresa WHERE nrcuit=$cuit";
	$respuesta = $mysqli -> query($consulta);
	$empresaData = $respuesta -> fetch_assoc();
	//echo $consulta; echo "<br>";
	
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
	
	// Cargo la plantilla
	$twig->display('nuevoEmpleado.html',array("userName" => $_SESSION['userNombre'], "provincias" => $provincias, "categorias" => $categorias));

?>