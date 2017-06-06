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
	
	$idRama = $empresaData['rramaa'];
	$consRama = "SELECT * FROM rama WHERE id = $idRama";
	$respRama = $mysqli -> query($consRama);
	$ramaData = $respRama -> fetch_assoc();
	
	$idProvin = $empresaData['provin'];
	$consProvin = "SELECT * FROM provincia WHERE id = $idProvin";
	$respProvin = $mysqli -> query($consProvin);
	$provinData = $respProvin -> fetch_assoc();

	
	$empresa = (object) array('cuit' => $empresaData['nrcuit'], 'nombre' => $empresaData['nombre'], 'domicilio' => $empresaData['domile'], 'localidad' => $empresaData['locali'],'provincia' => $provinData['descripcion'], 'codpostal' => $empresaData['copole'],  'telefono' => $empresaData['telfon'], 'email' => $empresaData['emails'], 'actividad' => $empresaData['activi'], 'rama' => $ramaData['descripcion'], 'inicio' => invertirFecha($empresaData['fecini']));

	// Cargo la plantilla
	$twig->display('perfilEmpresa.html',array("noleidos" => $_SESSION['noleidos'], "userName" => $_SESSION['userNombre'], "empresa" => $empresa));


?>