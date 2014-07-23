<?php session_save_path("sesiones");
session_start();
include('lib/php/verificaSesion.php');
include('lib/php/verificaConexion.php');
include('lib/php/funciones.php');
$root = '';
// Incluyo el template engine
include('includes/templateEngine.inc.php');

$nrcuit =  $_SESSION['userCuit'];
if (isset($_GET['cuil'])) {
	$nrcuil =  $_GET['cuil'];
	//Ejecucion de la sentencia SQL
	$sqlInsertFamilia = "INSERT into familiadebaja SELECT * from familia where nrcuil = ?";
	$sqlUpdateBajadaFamilia = "UPDATE familiadebaja SET bajada = ? where nrcuil = ?";
	
	$sqlInsertEmpleado = "INSERT into empleadosdebaja SELECT * from empleados where nrcuit = ? and nrcuil = ?";
	$sqlUpdateBajadaEmpleado = "UPDATE empleadosdebaja SET bajada = ? where nrcuit = ? and nrcuil = ?";
	
	$sqlDeleteEmpleado = "DELETE from empleados where nrcuit = ? and nrcuil = ?";
	$sqlDeleteFamiliares = "DELETE from familia where nrcuil = ?";
	
	try {
		if (($stmt = $mysqli->prepare($sqlDeleteEmpleado)) && ($stmt2 = $mysqli->prepare($sqlDeleteFamiliares)) && ($stmt4 = $mysqli->prepare($sqlInsertEmpleado)) && ($stmt3 = $mysqli->prepare($sqlInsertFamilia)) && ($stmt5 = $mysqli->prepare($sqlUpdateBajadaEmpleado)) && ($stmt6 = $mysqli->prepare($sqlUpdateBajadaFamilia)) ) {	
			$bajada = 0;
			
			$stmt3->bind_param('s', $nrcuil);
			$stmt3->execute();
			$stmt3->close();
			
			$stmt6->bind_param('is', $bajada, $nrcuil);
			$stmt6->execute();
			$stmt6->close();
			
			$stmt4->bind_param('ss', $nrcuit, $nrcuil);
			$stmt4->execute();
			$stmt4->close();
			
			$stmt5->bind_param('iss', $bajada, $nrcuit, $nrcuil);
			$stmt5->execute();
			$stmt5->close();
			
			$stmt2->bind_param('s', $nrcuil);
			$stmt2->execute();
			$stmt2->close();
			
			$stmt->bind_param('ss', $nrcuit, $nrcuil);
			$stmt->execute();
			$stmt->close();
			
			$pagina = "listaEmpleados.php";
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
