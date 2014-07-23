<?php session_save_path("sesiones");
session_start();
include('lib/php/verificaSesion.php');
include('lib/php/verificaConexion.php');
include('lib/php/funciones.php');
$root = '';
// Incluyo el template engine
include('includes/templateEngine.inc.php');

$datos = array_values($_POST);
//var_dump($datos);
if (sizeof($datos) > 0) {
	$nrcuit =  $_SESSION['userCuit'];
	$nrcuil =  $_GET['cuil'];
	$id = $_GET['id'];
	
	$apellido = strtoupper($datos[0]);
	$nombre = strtoupper($datos[1]);
	$codpar = $datos[2];
	$sexo = $datos[3];
	$fecnac = fechaParaGuardar($datos[4]);
	$fecing = fechaParaGuardar($datos[5]);
	$tipdoc = $datos[6];
	$numdoc = $datos[7];
	$benefi = $datos[8];
	
	
	//Ejecucion de la sentencia SQL
	$sqlActualizaPerfil = "update familia set 
	nombre = ?,
	apelli = ?,
	codpar = ?,
	ssexxo = ?,
	fecnac = ?,
	fecing = ?,
	tipdoc = ?,
	nrodoc = ?,
	benefi = ?
	where id = ? and nrcuil = ?";
	
	try {
		if ($stmt = $mysqli->prepare($sqlActualizaPerfil)) {
			$stmt->bind_param('sssssssssss', $nombre, $apellido, $codpar, $sexo, $fecnac, $fecing, $tipdoc, $numdoc, $benefi, $id, $nrcuil);
			$stmt->execute();
			$stmt->close();
			$pagina = "perfilEmpleado.php?cuil=$nrcuil";
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
