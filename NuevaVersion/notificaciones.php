<?php session_save_path("sesiones");
session_start();

include('lib/php/verificaSesion.php');
include('lib/php/verificaConexion.php');
include('lib/php/funciones.php');
$root = '';
// Incluyo el template engine
include('includes/templateEngine.inc.php');

$consultaNotificaciones = "SELECT id, tiponotificacion, DATE_FORMAT(fechanotificacion,'%d-%m-%Y') as fechanotificacion, asunto, mensaje, leida FROM notificaciones WHERE nrcuit = '".$_SESSION['userID']."' and eliminada = 0 ORDER BY fechanotificacion DESC";
if ($sentencia = $mysqli->prepare($consultaNotificaciones)) {
   	$sentencia->execute();
   	$sentencia->bind_result($id, $tiponotificacion, $fechanotificacion, $asunto, $mensaje, $leida);
	$i = 0;
	while ($sentencia->fetch()) {
		$notificaciones[$i] = array('id' => $id, 'tiponotificacion' => $tiponotificacion, 'fechanotificacion' => $fechanotificacion, 'asunto' => $asunto, 'mensaje' => $mensaje, 'leida' => $leida);
		$i = $i + 1;
   	}
}

$twig->display('notificaciones.html',array("noleidos" => $_SESSION['noleidos'], "userName" => $_SESSION['userNombre'], "notificaciones" => $notificaciones));

?>