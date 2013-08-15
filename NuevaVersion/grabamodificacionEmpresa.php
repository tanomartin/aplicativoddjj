<?php session_save_path("sesiones");
session_start();

include('lib/php/conexion.php');
include('lib/php/funciones.php');

$datos = array_values($_POST);

$nrcuit =  $_SESSION['userCuit'];
$nombre = strtoupper($datos [0]);
$domile = strtoupper($datos [1]);
$locali = strtoupper($datos [2]);
$provin = $datos [3];
$copole = strtoupper($datos [4]);
$telfon = $datos [5];
$emails = $datos [6];
$activi = $datos [7];
$fecini = fechaParaGuardar($datos [8]);

//Ejecucion de la sentencia SQL
$sql = "update empresa set 
nombre = '$nombre',
domile = '$domile',
locali = '$locali',
provin = '$provin',
copole = '$copole',
telfon = '$telfon',
emails = '$emails',
activi = '$activi',
fecini = '$fecini'
where nrcuit = '$nrcuit'
";

print($sql);
//$result = mysql_db_query("uv0472_aplicativo",$sql,$db);

?>
