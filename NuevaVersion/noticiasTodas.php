<?php session_save_path("sesiones");
session_start();

include('lib/php/verificaSesion.php');
include('lib/php/verificaConexion.php');
include('lib/php/funciones.php');
$root = '';
// Incluyo el template engine
include('includes/templateEngine.inc.php');

$today = date("Y-n-j");
$consultaNoticias = "SELECT * FROM noticias where fechavencimiento > '$today' or fechavencimiento is null order by prioritaria DESC, fechaalta DESC";
//print($consultaNoticias."<br>");
if ($sentencia = $mysqli->prepare($consultaNoticias)) {
   	$sentencia->execute();
   	$sentencia->bind_result($id, $fechaalta, $fechavencimiento, $descripcioncorta, $descripcionlarga, $prioritaria);
	$i = 0;
	while ($sentencia->fetch()) {
		$noticias[$i] = array('id' => $id, 'fechaalta' => invertirFecha($fechaalta), 'fechavencimiento' => $fechavencimiento, 'descripcioncorta' => $descripcioncorta, 'descripcionlarga' => $descripcionlarga, 'prioritaria' => $prioritaria);
		$i = $i + 1;
   	}
}

$twig->display('noticiasTodas.html',array("userName" => $_SESSION['userNombre'], "noticias" => $noticias));

?>