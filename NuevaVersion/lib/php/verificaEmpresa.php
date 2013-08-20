<?php session_save_path("sesiones");
session_start();

$consulta = sprintf("SELECT * FROM empresa WHERE nrcuit='%s' AND claveacc='%s' LIMIT 1", trim($data['usuario-cuit']),trim($data['usuario-clave']));

// Ejecuto la cosnulta
$respuesta = $dbLink -> query($consulta);

// Verifico login exitoso
if($respuesta -> num_rows != 0){
	$userData = $respuesta -> fetch_assoc();
	$respuestaLogin = true;

	$_SESSION['userLogin'] = true;
	$_SESSION['userNombre'] = $userData['nombre']." - ".$userData['nrcuit'];
	$_SESSION['userCuit'] = $userData['nrcuit'];
	$_SESSION['userID'] = $userData['nrcuit'];
	$_SESSION['host'] = $_SERVER['SERVER_NAME'];
	$_SESSION['dbname'] = "madera";
}
?>


