<?php session_save_path("sesiones");
session_start();

$consulta = sprintf("SELECT * FROM empresa WHERE nrcuit='%s' AND claveacc='%s' LIMIT 1", trim($data['usuario-cuit']),trim($data['usuario-clave']));
$consuMge = sprintf("SELECT * FROM habilita WHERE nrcuit='%s' LIMIT 1", trim($data['usuario-cuit']));

// Ejecuto la consulta de empresa
$respuesta = $dbLink -> query($consulta);

// Verifico login exitoso
if($respuesta -> num_rows != 0){
	$userData = $respuesta -> fetch_assoc();
	$respuestaLogin = true;

	// Ejecuto la consulta de habilita
	$respueMge = $dbLink -> query($consuMge);

	$_SESSION['userLogin'] = true;
	$_SESSION['userNombre'] = $userData['nombre']." - ".$userData['nrcuit'];
	$_SESSION['userCuit'] = $userData['nrcuit'];
	$_SESSION['userID'] = $userData['nrcuit'];
	$_SESSION['host'] = $_SERVER['SERVER_NAME'];

	if($respueMge -> num_rows != 0){
		$mgeData = $respueMge -> fetch_assoc();
		$_SESSION['userMge'] = (bool)$mgeData['autori'];
	} else {
		$_SESSION['userMge'] = (bool)0;
	}
}
?>


