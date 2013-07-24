<?php session_save_path("sesiones");
session_start();
if($_SESSION['nrcuit'] == null)
	header ("Location: caducaSes.php");
include("lib/conexion.php");

$datos = array_values($_POST);
$cuit = $_SESSION['nrcuit'];
$contraActual = $datos[0];
$contraNueva = $datos[1];
$repiteContra = $datos[2];

$sqlContraActual = "select * from empresa where nrcuit = '$cuit' and claveacc = '$contraActual'";
$resContraActual = mysql_db_query("uv0472_aplicativo",$sqlContraActual,$db);
$resultado = mysql_num_rows($resContraActual);

if ($resultado == 1) {
  	$sqlUpdateContra = "Update empresa set claveacc = '$contraNueva' where nrcuit = '$cuit'";
	$resUpdateContra = mysql_db_query("uv0472_aplicativo",$sqlUpdateContra,$db);
	
	$rowEmpresa = mysql_fetch_array($resContraActual);	
	$asunto = "Cambio de Contraseña del sitio www.usimra.com.ar";
	$mensaje = $rowEmpresa['nombre'].": " . "\r\n";
	$mensaje .= "La empresa con CUIT ".$cuit." cambio su contraseña.";
	$cabeceras .= "MIME-Version: 1.0" . "\r\n";
	$cabeceras .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
	$cabeceras .= "From: U.S.I.M.R.A. <no-replay@usimra.com.ar>" . "\r\n";
	$mail = "sistemas@usimra.com.ar";

	mail($mail, $asunto, $mensaje, $cabeceras);
	
	header ('Location: cambioContrasenia.php?error=2');	
} else {
	header ('Location: cambioContrasenia.php?error=1');	
}

?>