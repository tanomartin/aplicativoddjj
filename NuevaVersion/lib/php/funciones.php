<?php session_save_path("sesiones");
session_start();

include('lib/php/conexion.php');

function userLogin($data,$dbLink){
	// Bandera de logueo
	$respuestaLogin = false;

	// Verifico que vengan los parametros
	if(!empty($data) && !empty($dbLink)) {
		include('lib/php/verificaEmpresa.php');
	}
	return $respuestaLogin;
}

function invertirFecha($fecha) {
	$dia = substr($fecha,8,2);
	$mes = substr($fecha,5,2);
	$anio = substr($fecha,0,4);
	$fechainv = $dia."/".$mes."/".$anio;
	return($fechainv);
}


?>