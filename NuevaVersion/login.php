<?php session_save_path("sesiones");
session_start();

// Directorio Raíz de la app
// Es utilizado en templateEngine.inc.php
$root = '';

// Incluyo el template engine
include('includes/templateEngine.inc.php');
include('lib/php/conexion.php');
include('lib/php/funciones.php');
$today = date("Y-n-j");
$consultaNoticias = "SELECT * FROM noticias where fechavencimiento > '$today' or fechavencimiento is null order by prioritaria DESC, fechaalta LIMIT 3";
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

//var_dump($noticias);
// Cargo la plantilla

$navegador = getBrowser();
if(strcmp($navegador['name'],"Internet Explorer") == 0 || strcmp($navegador['name'],"Mozilla Firefox") == 0 || strcmp($navegador['name'],"Google Chrome") == 0 || strcmp($navegador['name'],"Apple Safari") == 0) {
	if (strcmp($navegador['name'],"Internet Explorer") == 0) {
		$version = (float)$navegador['version'];
		if($version < 9) {
			$twig->display('navegadorError.html');
		} else {
			$twig->display('login.html', array("noticias" => $noticias, "login" => $_SESSION['userLogin']));
		}
	} else {
		$twig->display('login.html', array("noticias" => $noticias, "login" => $_SESSION['userLogin']));
	}
} else {
	$twig->display('navegadorError.html');
}

?>