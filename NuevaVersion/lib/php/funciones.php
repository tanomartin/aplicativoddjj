<?php session_save_path("sesiones");
session_start();

include('lib/php/conexion.php');

function userLogin($data,$dbLink) {
	// Bandera de logueo
	$respuestaLogin = false;

	// Verifico que vengan los parametros
	if(!empty($data) && !empty($dbLink)) {
		include('lib/php/verificaEmpresa.php');
	}
	return $respuestaLogin;
}

function invertirFecha($fecha) {
	$dia = substr($fecha,8,2);
	$mes = substr($fecha,5,2);
	$anio = substr($fecha,0,4);
	$fechainv = $dia."/".$mes."/".$anio;
	return($fechainv);
}

function fechaParaGuardar($fecha) {
	if ($fecha == "") {
		return("0000-00-00");
	}
	$dia = substr($fecha,0,2);
	$mes = substr($fecha,3,2);
	$anio = substr($fecha,6,4);
	$fechaLista = $anio."-".$mes."-".$dia;
	return($fechaLista);
}

function verificaUsuarioClave($data,$dbLink) {
	// Inicializo la respuesta
	$response = false;

	// Verifico que vengan los parametros
	if(!empty($data) && !empty($dbLink)) {
		$consulta = sprintf("SELECT * FROM empresa WHERE nrcuit='%s' AND emails='%s' LIMIT 1", trim($data['clave_cuit']),trim($data['clave_correo']));

		// Ejecuto la consulta
		$respuesta = $dbLink -> query($consulta);

		// Verifico si encuentro datos
		if($respuesta -> num_rows != 0){
			// Devuelvo la respuesta en TRUE
			$response = true;
		}
	}
	return $response;
}

function enviaMail($data,$dbLink) {
	// Inicializo la respuesta
	$response = false;
	if(!empty($data) && !empty($dbLink)) {
		$consulta = sprintf("SELECT * FROM empresa WHERE nrcuit='%s' AND emails='%s' LIMIT 1", trim($data['clave_cuit']),trim($data['clave_correo']));

		// Ejecuto la consulta
		$respuesta = $dbLink -> query($consulta);

		// Verifico si encuentro datos
		if($respuesta -> num_rows != 0){
			//$userData = $respuesta -> fetch_assoc();

			// Establezco el asunto
			//$asunto = "Recordatorio de Contraseña del sitio www.usimra.com.ar";
	
			// Armo el mensaje
			//$mensaje = $userData['nombre'].": " . "\r\n";
			//$mensaje .= "La contraseña requerida del usuario ".$userData['nrcuit']." es ".$userData['claveacc']." .";
	
			// Para enviar correo HTML, la cabecera Content-type debe definirse
			//$cabeceras .= "MIME-Version: 1.0" . "\r\n";
			//$cabeceras .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
	
			// Cabeceras adicionales
			//$cabeceras .= "From: U.S.I.M.R.A. <no-replay@usimra.com.ar>" . "\r\n";
			//$cabeceras .= 'Bcc: sistemas@usimra.com.ar' . "\r\n";
	
			// Envio el mail
			//if(mail($userData['emails'], $asunto, $mensaje, $cabeceras)) {
				// Devuelvo la respuesta en TRUE
				//$response = true;
			//}
			// Simulo que envio bien el mail !!! NO OLVIDARSE DE SACARLO !!!!!!!!!
			$response = true;
		}
	}
	return $response;
}

?>