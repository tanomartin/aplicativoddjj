<?php 
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_httponly', 1);

if(empty($_SESSION) || $_SESSION['userLogin'] == false || !isset($_SESSION["userNombre"]) || !isset($_SESSION["maxtimeSession"]) || !isset($_SESSION["ultimoAcceso"]) || !isset($_SESSION['userCuit'])){
	header("Location:sesionCaida.php");
}

$fechaGuardada = $_SESSION["ultimoAcceso"]; 
$ahora = date("Y-n-j H:i:s"); 
$tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada)); 
$maxSession = $_SESSION["maxtimeSession"];

//40 minutos de sesion
if($tiempo_transcurrido >= $maxSession) { 
	header("Location:sesionCaida.php");
} else {
	$_SESSION["ultimoAcceso"] = $ahora; 
}

?>