<?php  session_save_path("sesiones");
session_start();
include('lib/php/verificaSesion.php');
include('lib/php/verificaConexion.php');
$root = '';
// Incluyo el template engine
include('includes/templateEngine.inc.php');

$id = $_GET['id'];
$leido = $_GET['leida'];


$sqlEliminar = "UPDATE notificaciones SET eliminada = 1 WHERE id = ?";

try {
	if ($stmt = $mysqli->prepare($sqlEliminar)) {
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$stmt->close();
	}
	header("Location: notificaciones.php");
}
catch(Exception $e){
	$mysqli->rollback();
	die("ERROR MYSQLI: <br>".$e->getMessage() );
}

?>