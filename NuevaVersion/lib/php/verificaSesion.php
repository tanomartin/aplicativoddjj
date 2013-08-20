<?php session_save_path("sesiones");
session_start();

//TODO ver el tema del tiempo de la sesion... si esta ok actulizarlo sino eliminar la sesion y mandarlo al error.
if(empty($_SESSION) || $_SESSION['userLogin'] == false){
	header("Location:sesionCaida.php");
}

?>