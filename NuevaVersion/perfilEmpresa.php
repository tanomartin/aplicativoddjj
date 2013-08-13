<?php session_save_path("sesiones");
session_start();
include('lib/php/conexion.php');
include('lib/php/funciones.php');
$root = '';

if(!empty($_SESSION) && $_SESSION['userLogin'] == true){
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
	
	$empresa = (object) array('cuit' => $empresaData['nrcuit'], 'nombre' => $empresaData['nombre'], 'domicilio' => $empresaData['domile'], 'localidad' => $empresaData['locali'],'provincia' => $empresaData['provin'], 'codpostal' => $empresaData['copole'],  'telefono' => $empresaData['telfon'], 'email' => $empresaData['emails'], 'actividad' => $empresaData['activi'], 'rama' => $ramaData['descripcion'], 'inicio' => invertirFecha($empresaData['fecini']));

	// Cargo la plantilla
	$twig->display('perfilEmpresa.html',array("userName" => $_SESSION['userNombre'], "cuit" => $_SESSION['userCuit'], "empresa" => $empresa));
}
else{
	header("Location:login.php");
}
?>