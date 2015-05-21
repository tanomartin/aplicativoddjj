<?php session_save_path("sesiones");
session_start();
include('lib/php/verificaSesion.php');
include('lib/php/verificaConexion.php');
include('lib/php/funciones.php');
$root = '';
// Incluyo el template engine
include('includes/templateEngine.inc.php');

$datos = array_values($_POST);
//var_dump($datos);
if (sizeof($datos) > 0) {
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
	$direccion = strtoupper($datos[8]);
	$locale = strtoupper($datos[9]);
	$provin = $datos[10];
	$codpos = strtoupper($datos[11]);
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
	activo = ?,
	bajada = ?
	where nrcuit = ? and nrcuil = ?";
	
	//echo $sqlActualizaPerfil;
	
	try {
		if ($stmt = $mysqli->prepare($sqlActualizaPerfil)) {
			$bajada = 0;
			$stmt->bind_param('sssssssssssssssiss', $apellido, $nombre, $fecini, $tipdoc, $numdoc, $sexo, $fecnac, $estado, $direccion, $locale, $codpos, $provin, $nacion, $catego, $activo, $bajada, $nrcuit, $nrcuil);
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
} else {
	$twig->display('accesoDirecto.html',array("userName" => $_SESSION['userNombre']));
}

?>
