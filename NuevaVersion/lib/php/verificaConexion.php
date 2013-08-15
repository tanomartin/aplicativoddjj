<?php session_save_path("sesiones");
session_start();

include('conexion.php');

if ($errorDbConexion) {
	$pagina = $root."conexionCaida.php";
	header("Location:".$pagina);
}

?>