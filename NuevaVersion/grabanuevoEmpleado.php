<?php session_save_path("sesiones");
session_start();
include('lib/php/verificaSesion.php');
include('lib/php/verificaConexion.php');
include('lib/php/funciones.php');

$datos = array_values($_POST);
//var_dump($datos);

$nrcuit =  $_SESSION['userCuit'];
$nrcuil = $datos[0];
$apellido = strtoupper($datos[1]);
$nombre = strtoupper($datos[2]);
$fecini = fechaParaGuardar($datos[3]);
$tipdoc = $datos[4];
$numdoc = $datos[5];
$sexo = $datos[6];
$fecnac = fechaParaGuardar($datos[7]);
$estado = $datos[8];
$direccion = strtoupper($datos[9]);
$locale = strtoupper($datos[10]);
$provin = $datos[11];
$codpos = strtoupper($datos[12]);
$nacion = strtoupper($datos[13]);
$catego = $datos[14];
$activo = $datos[15];
$bajada = 0;

//Ejecucion de la sentencia SQL
$sqlNuevoEmpleado = "INSERT INTO empleados(nrcuit,nrcuil,apelli,nombre,fecing,tipdoc,nrodoc,ssexxo,fecnac,estciv,direcc,locale,copole,provin,nacion,catego,activo,bajada) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

//echo $sqlActualizaPerfil;

try {
	if ($stmt = $mysqli->prepare($sqlNuevoEmpleado)) {
		$stmt->bind_param('sssssssssssssssssi', $nrcuit, $nrcuil, $apellido, $nombre, $fecini, $tipdoc, $numdoc, $sexo, $fecnac, $estado, $direccion, $locale, $codpos, $provin, $nacion, $catego, $activo, $bajada);
		$stmt->execute();
		$stmt->close();
		$pagina = "listaEmpleados.php";
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
