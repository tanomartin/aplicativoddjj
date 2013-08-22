<?php session_save_path("sesiones");
session_start();
include('lib/php/verificaSesion.php');
include('lib/php/verificaConexion.php');
include('lib/php/funciones.php');

$datos = array_values($_POST);

//var_dump($datos);

$nrcuit =  $_SESSION['userCuit'];
$nrcuil =  $_GET['cuil'];
$apellido = strtoupper($datos[0]);
$nombre = strtoupper($datos[1]);
$fecini = fechaParaGuardar($datos[2]);
$tipdoc = $datos[3];
$numdoc = $datos[4];
$sexo = $datos[5];
$fecnac = fechaParaGuardar($datos[6]);
$estado = $datos[7];
$direccion = $datos[8];
$locale = $datos[9];
$codpos = strtoupper($datos[11]);
$provin = $datos[10];
$nacion = strtoupper($datos[12]);
$catego = $datos[13];
$activo = $datos[14];


//Ejecucion de la sentencia SQL
$sqlActualizaPerfil = "update empleados set 
apelli = ?,
nombre = ?,
fecing = ?,
tipdoc = ?,
nrodoc = ?,
ssexxo = ?,
fecnac = ?,
estciv = ?,
direcc = ?,
locale = ?,
copole = ?,
provin = ?,
nacion = ?,
catego = ?,
activo = ?
where nrcuit = ? and nrcuil = ?";

//echo $sqlActualizaPerfil;

try {
	if ($stmt = $mysqli->prepare($sqlActualizaPerfil)) {
		$stmt->bind_param('sssssssssssssssss', $apellido, $nombre, $fecini, $tipdoc, $numdoc, $sexo, $fecnac, $estado, $direccion, $locale, $codpos, $provin, $nacion, $catego, $activo, $nrcuit, $nrcuil);
		$stmt->execute();
		$stmt->close();
		$pagina = "perfilEmpleado.php?cuil=$nrcuil";
		Header("Location: $pagina"); 
	} else {
		 die("ERROR MYSQLI: <br>".$mysqli->error );
	}
} 
catch(Exception $e){
    $mysqli->rollback();
    die("ERROR MYSQLI: <br>".$e->getMessage() );
}

?>
