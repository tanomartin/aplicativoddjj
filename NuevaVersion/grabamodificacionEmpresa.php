<?php session_save_path("sesiones");
session_start();
include('lib/php/verificaSesion.php');
include('lib/php/verificaConexion.php');
include('lib/php/funciones.php');
$root = '';
// Incluyo el template engine
include('includes/templateEngine.inc.php');

$datos = array_values($_POST);
if (sizeof($datos) > 0) {
	$nrcuit =  $_SESSION['userCuit'];
	$nombre = strtoupper($datos [0]);
	$domile = strtoupper($datos [1]);
	$locali = strtoupper($datos [2]);
	$provin = $datos [3];
	$copole = strtoupper($datos [4]);
	$telfon = $datos [5];
	$emails = $datos [6];
	$activi = $datos [7];
	
	//Ejecucion de la sentencia SQL
	$sqlActualizaPerfil = "update empresa set 
	nombre = ?,
	domile = ?,
	locali = ?,
	provin = ?,
	copole = ?,
	telfon = ?,
	emails = ?,
	activi = ?
	where nrcuit = ?";
	
	
	try {
		if ($stmt = $mysqli->prepare($sqlActualizaPerfil)) {
			$stmt->bind_param('sssssssss', $nombre, $domile, $locali, $provin, $copole, $telfon, $emails, $activi, $nrcuit);
			$stmt->execute();
			$stmt->close();
			$_SESSION['userNombre'] = $nombre." - ".$nrcuit;
			$pagina = "perfilEmpresa.php";
			Header("Location: $pagina"); 
		} else {
			 die("ERROR MYSQLI: <br>".$mysqli->error );
		}
	} 
	catch(Exception $e){
		$mysqli->rollback();
		die("ERROR MYSQLI: <br>".$e->getMessage() );
	}
} else {
	$twig->display('accesoDirecto.html',array("userName" => $_SESSION['userNombre']));
}
?>
