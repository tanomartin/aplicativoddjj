<?php 
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

	// Verifico que vengan los parametros
	if(!empty($data) && !empty($dbLink)) {
		$consulta = sprintf("SELECT * FROM empresa WHERE nrcuit='%s' AND emails='%s' LIMIT 1", trim($data['clave_cuit']),trim($data['clave_correo']));

		// Ejecuto la consulta
		$respuesta = $dbLink -> query($consulta);

		// Verifico si encuentro datos
		if($respuesta -> num_rows != 0){
			$userData = $respuesta -> fetch_assoc();

			// Establezco el asunto
			$asunto = "Recordatorio de Contraseña del sitio www.usimra.com.ar";
	
			// Armo el mensaje
			$mensaje = $userData['nombre'].": " . "\r\n";
			$mensaje .= "La contraseña requerida del usuario ".$userData['nrcuit']." es ".$userData['claveacc']." .";
	
			// Para enviar correo HTML, la cabecera Content-type debe definirse
			$cabeceras .= "MIME-Version: 1.0" . "\r\n";
			$cabeceras .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
	
			// Cabeceras adicionales
			$cabeceras .= "From: U.S.I.M.R.A. <no-replay@usimra.com.ar>" . "\r\n";
			$cabeceras .= 'Bcc: sistemas@usimra.com.ar' . "\r\n";

			// Envio el mail
			if(mail($userData['emails'], $asunto, $mensaje, $cabeceras)) {
				// Devuelvo la respuesta en TRUE
				$response = true;
			}
			// Simulo que envio bien el mail !!! NO OLVIDARSE DE SACARLO !!!!!!!!!
			//$response = true;
		}
	}
	return $response;
}

function verificaCuit($data,$dbLink) {
	// Inicializo la respuesta
	$response = true;

	// Verifico que vengan los parametros
	if(!empty($data) && !empty($dbLink)) {
		$consulta = sprintf("SELECT * FROM empresa WHERE nrcuit='%s' LIMIT 1", trim($data['cuit']));

		// Ejecuto la consulta
		$respuesta = $dbLink -> query($consulta);

		// Verifico si encuentro datos
		if($respuesta -> num_rows != 0){
			// Devuelvo la respuesta en FALSE
			$response = false;
		}
	}
	return $response;
}

function guardaAlta($data,$dbLink) {
	// Inicializo la respuesta
	$response = false;

	// Verifico que vengan los parametros
	if(!empty($data) && !empty($dbLink)) {
		include('lib/php/funciones.php');

		$nrcuit = $data['cuit'];
		$nombre = strtoupper($data['nombre']);
		$domici = strtoupper($data['domicilio']);
		$locali = strtoupper($data['localidad']);
		$provin = $data['provincia'];
		$copole = strtoupper($data['codpostal']);
		$telfon = $data['telefono'];
		$emails = $data['email'];
		$activi = $data['actividad'];
		$corama = $data['rama'];
		$fecini = fechaParaGuardar($data['inicio']);
		$clavea = $data['clave'];
		$autori = 0;
		$bajada = 0;

		//Consulto Tabla Actividad para tomar la descripcion
		$sqlActividad = "SELECT * FROM actividad WHERE id = $activi";
		$resActividad = $dbLink -> query($sqlActividad);
		$datActividad = $resActividad -> fetch_assoc();

		$activi = $datActividad['descripcion'];

		//Armo consulta SQL de Tabla Empresa
		$sqlAddEmpresa = "INSERT INTO empresa (nrcuit,nombre,domile,locali,provin,copole,telfon,emails,activi,rramaa,fecini,claveacc,bajada) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";

		//Armo consulta SQL de Tabla Habilita
		$sqlAddHabilita = "INSERT INTO habilita (nrcuit,autori) VALUES (?,?)";

		//Ejecuto los inserts
		try {
			if ($setActuEmpre = $dbLink->prepare($sqlAddEmpresa)) {
				$setActuEmpre->bind_param('ssssissssissi', $nrcuit, $nombre, $domici, $locali, $provin, $copole, $telfon, $emails, $activi, $corama, $fecini, $clavea, $bajada);
				$setActuEmpre->execute();
				$setActuEmpre->close();

				// Devuelvo la respuesta en TRUE
				$response = true;
	
				if ($setActuHabil = $dbLink->prepare($sqlAddHabilita)) {
					$setActuHabil->bind_param('si', $nrcuit, $autori);
					$setActuHabil->execute();
					$setActuHabil->close();
				} else {
					 die("ERROR MYSQLI: <br>".$dbLink->error );
				}
			} else {
				 die("ERROR MYSQLI: <br>".$dbLink->error );
			}
		} 
		catch(Exception $e) {
			$dbLink->rollback();
			die("ERROR MYSQLI: <br>".$e->getMessage() );
		}
	}
	return $response;
}
?>