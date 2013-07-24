<?php session_save_path("sesiones");
session_start();
if($_SESSION['nrcuit'] == null)
	header ("Location: caducaSes.php");

$datos = array_values($HTTP_POST_VARS);
$nrcui01 = $datos [0];
$nrcui02 = $datos [1];
$nrcui03 = $datos [2];
$nrcuil = $nrcui01.$nrcui02.$nrcui03;

$nombre = $datos [3];
$nombre = strtoupper($nombre);
$apelli = $datos [4];
$apelli = strtoupper($apelli);
$fec01 = $datos [5];
$fec02 = $datos [6];
$fec03 = $datos [7];
$fecing = $fec03.$fec02.$fec01;

$tipdoc = $datos [8];
$nrodoc = $datos [9];
$ssexxo = $datos [10];
$fecnac01 = $datos [11];
$fecnac02 = $datos [12];
$fecnac03 = $datos [13];
$fecnac = $fecnac03.$fecnac02.$fecnac01;
$estciv = $datos [14];
$direcc = $datos [15];
$direcc = strtoupper($direcc);
$locale = $datos [16];
$locale = strtoupper($locale);
$copole = $datos [17];
$copole = strtoupper($copole);
$provin = $datos [18];
$nacion = $datos [19];
$nacion = strtoupper($nacion);
$catego = $datos [20];
$activo = $datos [21];

include("lib/conexion.php");
require("lib/verificaCuit.php");
$pepe = validacuit($nrcuil);
if ($pepe == 0) {
	$pagina = "altaEmpleado.php?err=1";
	header ("location:$pagina");
} else {
	$sql = "INSERT INTO empleados (nrcuit,nrcuil,apelli,nombre,fecing,tipdoc,nrodoc,ssexxo,fecnac,estciv,direcc,locale,copole,provin,nacion,catego,activo)
	VALUES ('$nrcuit','$nrcuil','$apelli','$nombre','$fecing','$tipdoc','$nrodoc','$ssexxo','$fecnac','$estciv','$direcc','$locale','$copole','$provin','$nacion','$catego','$activo')";
	$result = mysql_db_query("uv0472_aplicativo",$sql,$db);
	
	$pagina = "muestraEmpleado.php?nrcuil=$nrcuil";
	header ("location:$pagina");
}

?>