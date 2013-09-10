<?php session_save_path("sesiones");
session_start();
include('lib/php/verificaSesion.php');
include('lib/php/verificaConexion.php');
include('lib/php/funciones.php');

$nrcuit =  $_SESSION['userCuit'];
$nrcuil =  $_GET['cuil'];

//Ejecucion de la sentencia SQL
$sqlInsertEmpleado = "INSERT into empleadosdebaja SELECT * from empleados where nrcuit = ? and nrcuil = ?";
$sqlInsertFamilia = "INSERT into familiadebaja SELECT * from familia where nrcuil = ?";

$sqlDeleteEmpleado = "DELETE from empleados where nrcuit = ? and nrcuil = ?";
$sqlDeleteFamiliares = "DELETE from familia where nrcuil = ?";

try {
	if (($stmt = $mysqli->prepare($sqlDeleteEmpleado)) && ($stmt2 = $mysqli->prepare($sqlDeleteFamiliares)) && ($stmt4 = $mysqli->prepare($sqlInsertEmpleado)) && ($stmt3 = $mysqli->prepare($sqlInsertFamilia))) {	
		$stmt3->bind_param('s', $nrcuil);
		$stmt3->execute();
		$stmt3->close();
		
		$stmt4->bind_param('ss', $nrcuit, $nrcuil);
		$stmt4->execute();
		$stmt4->close();
		
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

?>
