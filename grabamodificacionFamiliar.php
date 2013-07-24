<?php session_save_path("sesiones");
session_start();
if($_SESSION['nrcuit'] == null)
	header ("Location: caducaSes.php");
	
$datos = array_values($HTTP_POST_VARS);


$nombre = $datos [0];
$nombre = strtoupper($nombre);
$apelli = $datos [1];
$apelli = strtoupper($apelli);
$codpar = $datos [2];
$ssexxo = $datos [3];
$fecnac01 = $datos [4];
$fecnac02 = $datos [5];
$fecnac03 = $datos [6];
$fecnac = $fecnac03.$fecnac02.$fecnac01;
$fec01 = $datos [7];
$fec02 = $datos [8];
$fec03 = $datos [9];
$fecing = $fec03.$fec02.$fec01;
$tipdoc = $datos [10];
$nrodoc = $datos [11];
$benefi = $datos[12];

include("lib/conexion.php");
$sql = "update familia
set
nombre = '$nombre',
apelli = '$apelli',
fecnac = '$fecnac',
tipdoc = '$tipdoc',
nrodoc = '$nrodoc',
ssexxo = '$ssexxo',
fecing = '$fecing',
codpar = '$codpar',
benefi = '$benefi'
where
id = '$id'
";
$result = mysql_db_query("uv0472_aplicativo",$sql,$db);

$pagina="muestraFamiliar.php?id=$id&nrcuil=$nrcuil";
header ("location:$pagina");
?>
