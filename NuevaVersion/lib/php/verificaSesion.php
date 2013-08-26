<?php 
//TODO ver el tema del tiempo de la sesion... si esta ok actulizarlo sino eliminar la sesion y mandarlo al error.
if(empty($_SESSION) || $_SESSION['userLogin'] == false){
	header("Location:sesionCaida.php");
}

?>