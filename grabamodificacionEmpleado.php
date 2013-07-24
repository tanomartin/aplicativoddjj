<?php session_save_path("sesiones");
session_start();
if($_SESSION['nrcuit'] == null)
	header ("Location: caducaSes.php");
	
$datos = array_values($HTTP_POST_VARS);

$nrcuil = $datos [0];
$nombre = $datos [1];
$nombre = strtoupper($nombre);
$apelli = $datos [2];
$apelli = strtoupper($apelli);
$fec01 = $datos [3];
$fec02 = $datos [4];
$fec03 = $datos [5];
$fecing = $fec03.$fec02.$fec01;
$tipdoc = $datos [6];
$nrodoc = $datos [7];
$ssexxo = $datos [8];
$fecnac01 = $datos [9];
$fecnac02 = $datos [10];
$fecnac03 = $datos [11];
$fecnac = $fecnac03.$fecnac02.$fecnac01;
$estciv = $datos [12];
$direcc = $datos [13];
$direcc = strtoupper($direcc);
$locale = $datos [14];
$locale = strtoupper($locale);
$copole = $datos [15];
$copole = strtoupper($copole);
$provin = $datos [16];
$nacion = $datos [17];
$nacion = strtoupper($nacion);
$catego = $datos [18];
$activo = $datos [19];

include("lib/conexion.php");
$sql = "update empleados
set nombre = '$nombre',
apelli = '$apelli',
fecing = '$fecing',

tipdoc = '$tipdoc',
nrodoc = '$nrodoc',
ssexxo = '$ssexxo',
fecnac = '$fecnac',
estciv = '$estciv',
direcc = '$direcc',
locale = '$locale',
copole = '$copole',
provin = '$provin',
nacion = '$nacion',
catego = '$catego',
activo = '$activo'

where nrcuit = '$nrcuit' and
nrcuil = '$nrcuil'
";
$result = mysql_db_query("uv0472_aplicativo",$sql,$db);

$pagina = "muestraEmpleado.php?nrcuil=$nrcuil";
header ("location:$pagina");
?>


