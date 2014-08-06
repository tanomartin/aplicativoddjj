<?php 
include('conexion.php');
if ($errorDbConexion) {
	$pagina = $root."conexionCaida.php";
	header("Location:".$pagina);
	exit(0);
}
?>