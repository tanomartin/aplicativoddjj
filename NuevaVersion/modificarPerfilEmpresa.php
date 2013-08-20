<?php session_save_path("sesiones");
session_start();
	include('lib/php/verificaConexion.php');
	include('lib/php/verificaSesion.php');
	
	include('lib/php/funciones.php');
	$root = '';

	// Incluyo el template engine
	include('includes/templateEngine.inc.php');
	
	$cuit = $_SESSION['userCuit'];
	$consulta = "SELECT * FROM empresa WHERE nrcuit=$cuit";
	$respuesta = $mysqli -> query($consulta);
	$empresaData = $respuesta -> fetch_assoc();
	
	$idRama = $empresaData['rramaa'];
	$consRama = "SELECT * FROM rama WHERE id = $idRama";
	$respRama = $mysqli -> query($consRama);
	$ramaData = $respRama -> fetch_assoc();

	
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

	
	$empresa = (object) array('cuit' => $empresaData['nrcuit'], 'nombre' => $empresaData['nombre'], 'domicilio' => $empresaData['domile'], 'localidad' => $empresaData['locali'],'provincia' => $empresaData['provin'], 'codpostal' => $empresaData['copole'],  'telefono' => $empresaData['telfon'], 'email' => $empresaData['emails'], 'actividad' => $empresaData['activi'], 'rama' => $ramaData['descripcion'], 'inicio' => invertirFecha($empresaData['fecini']));

	// Cargo la plantilla
	$twig->display('modificarPerfilEmpresa.html',array("userName" => $_SESSION['userNombre'], "empresa" => $empresa, "provincias" => $provincias));


?>