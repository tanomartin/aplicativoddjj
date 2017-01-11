<?php session_save_path("sesiones");
session_start();

// Directorio Raíz de la app
// Es utilizado en templateEngine.inc.php
$root = '';

// Incluyo el template engine
include('includes/templateEngine.inc.php');
include('lib/php/conexion.php');
include('lib/php/funciones.php');
require_once('lib/php/BrowserDetection.php');

$noticias = array();
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

//BAJA DE SISTEMA PARA TRABAJO
//$twig->display('estamosTrabajando.html');
//exit(0);
//**************************//

$browser = new BrowserDetection();
$navegador = $browser->getBrowser();
$version = $browser->getVersion();
 /*strcmp($navegador,"Firefox") == 0 ||*/
if(strcmp($navegador,"Internet Explorer") == 0 || strcmp($navegador,"Chrome") == 0 || strcmp($navegador,"Safari") == 0 )  {
	if (strcmp($navegador,"Internet Explorer") == 0) {
		if($version < 10) {
			$twig->display('navegadorError.html');
		} else {
			$twig->display('login.html', array("noticias" => $noticias, "login" => false));
		}
	} else {
		$twig->display('login.html', array("noticias" => $noticias, "login" => false));
	}
} else {
	$twig->display('navegadorError.html');
}

?>