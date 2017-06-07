<?php session_save_path("sesiones");
session_start();

include('lib/php/verificaSesion.php');
include('lib/php/verificaConexion.php');
include('lib/php/funciones.php');
$root = '';
// Incluyo el template engine
include('includes/templateEngine.inc.php');

$id = $_GET['id'];

try {
	$consultaNotificacion = "SELECT id, tiponotificacion, DATE_FORMAT(fechanotificacion,'%d-%m-%Y') as fechanotificacion, asunto, mensaje, leida FROM notificaciones WHERE id = $id";
	
	if ($sentencia = $mysqli->prepare($consultaNotificacion)) {
		$sentencia->execute();
		$sentencia->bind_result($id, $tiponotificacion, $fechanotificacion, $asunto, $mensaje, $leida);
		while ($sentencia->fetch()) {
			$notificacion = array('id' => $id, 'tiponotificacion' => $tiponotificacion, 'fechanotificacion' => $fechanotificacion, 'asunto' => $asunto, 'mensaje' => $mensaje, 'leida' => $leida);
			if ($leida == 0) {
				$_SESSION['noleidos'] -= 1;
				$fechalectura = date("Y-m-d H:i:s");
				$sqlLeida = "UPDATE notificaciones SET leida = 1, fechalectura = '$fechalectura' WHERE id = ?";
				if ($stmt = $mysqli->prepare($sqlLeida)) {
					$stmt->bind_param('i', $id);
					$stmt->execute();
					$stmt->close();
				}
			} 
		}
	}
	
	$twig->display('notificacion.html',array("noleidos" => $_SESSION['noleidos'], "userName" => $_SESSION['userNombre'], "notificacion" => $notificacion));
} catch(Exception $e){
	$mysqli->rollback();
	die("ERROR MYSQLI: <br>".$e->getMessage() );
}
?>