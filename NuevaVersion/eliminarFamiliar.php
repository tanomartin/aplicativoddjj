<?php session_save_path("sesiones");
session_start();
include('lib/php/verificaSesion.php');
include('lib/php/verificaConexion.php');
include('lib/php/funciones.php');

$nrcuit =  $_SESSION['userCuit'];
$nrcuil =  $_GET['cuil'];
$id =  $_GET['id'];

//Ejecucion de la sentencia SQL
$sqlDeleteFamiliar = "DELETE from familia where nrcuil = ? and nrcuit = ? and id = ?";
$sqlInsertFamilia = "INSERT INTO familiadebaja SELECT * from familia where nrcuil = ? and nrcuit = ? and id = ?";
$sqlUpdateBajadaFamilia = "UPDATE familiadebaja SET bajada = ? where nrcuil = ?";

try {
	if ( ($stmt = $mysqli->prepare($sqlDeleteFamiliar)) && ($stmt2 = $mysqli->prepare($sqlInsertFamilia)) && ($stmt3 = $mysqli->prepare($sqlUpdateBajadaFamilia))) {
		$stmt2->bind_param('sss', $nrcuil, $nrcuit, $id);
		$stmt2->execute();
		$stmt2->close();
		
		$bajada = 0;
		$stmt3->bind_param('isss', $bajada, $nrcuil, $nrcuit, $id);
		$stmt3->execute();
		$stmt3->close();
		
		$stmt->bind_param('sss', $nrcuil, $nrcuit, $id);
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

?>
