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

try {
	if ($stmt = $mysqli->prepare($sqlDeleteFamiliar)) {
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
