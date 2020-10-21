<?php session_save_path("sesiones");
session_start();
if(!empty($_SESSION) && $_SESSION['userLogin'] == true){
	include('lib/php/verificaSesion.php');
	include('lib/php/verificaConexion.php');
	include('lib/php/funciones.php');

	// Directorio Raíz de la app
	// Es utilizado en templateEngine.inc.php
	$root = '';
	//echo $_SESSION['userNombre'];
	// Incluyo el template engine
	include('includes/templateEngine.inc.php');
	
	
	$today = date("Y-n-j");
	$consultaNoticias = "SELECT * FROM noticias where fechavencimiento > '$today' or fechavencimiento is null order by prioritaria DESC, fechaalta LIMIT 3";
	//print($consultaNoticias."<br>");
	$noticias = array();
	if ($sentencia = $mysqli->prepare($consultaNoticias)) {
    	$sentencia->execute();
    	$sentencia->bind_result($id, $fechaalta, $fechavencimiento, $descripcioncorta, $descripcionlarga, $prioritaria);
		$i = 0;
		while ($sentencia->fetch()) {
			$noticias[$i] = array('id' => $id, 'fechaalta' => invertirFecha($fechaalta), 'fechavencimiento' => $fechavencimiento, 'descripcioncorta' => $descripcioncorta, 'descripcionlarga' => $descripcionlarga, 'prioritaria' => $prioritaria);
			$i = $i + 1;
    	}
	}
	
	//var_dump($noticias);
	// Cargo la plantilla
	$twig->display('index.html', array("noleidos" => $_SESSION['noleidos'], "userName" => $_SESSION['userNombre'], "userID" => $_SESSION['userID'], "noticias" => $noticias, "login" => $_SESSION['userLogin']));
} else {
	header("Location:login.php");
}
?>