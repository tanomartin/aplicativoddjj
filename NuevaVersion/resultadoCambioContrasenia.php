<?php session_save_path("sesiones");
	session_start();
	$root = '';
	include('lib/php/verificaSesion.php');
	include('lib/php/verificaConexion.php');
	
	// Incluyo el template engine
	include('includes/templateEngine.inc.php');

	if(isset($_POST) && !empty($_POST)) {
		// Verifico que las claves ingresadas sean distintas
		if(trim($_POST['claveActual']) != trim($_POST['claveNueva'])) {
			// Verifico que la clave actual sea correcta
			$sqlClaveActual = sprintf("SELECT * FROM empresa WHERE nrcuit='%s' AND claveacc='%s' LIMIT 1", $_SESSION['userCuit'],trim($_POST['claveActual']));
			$resClaveActual = $mysqli -> query($sqlClaveActual);
			if($resClaveActual -> num_rows != 0){
				$clanue = trim($_POST['claveNueva']);
				$nrcuit = $_SESSION['userCuit'];
				$claact = trim($_POST['claveActual']);

				$userData = $resClaveActual -> fetch_assoc();

				$sqlClaveNueva = "UPDATE empresa SET claveacc = ? WHERE nrcuit = ? AND claveacc = ?";

				try {
					if ($setactualiza = $mysqli->prepare($sqlClaveNueva)) {
						$setactualiza->bind_param('sss', $clanue, $nrcuit, $claact);
						$setactualiza->execute();
						$setactualiza->close();

						// Envio email a sistemas para dejar huella del cambio de clave
						$asunto = "Cambio de Contraseña del sitio www.usimra.com.ar";
						$mensaje = $userData['nombre'].": " . "\r\n";
						$mensaje .= "La empresa con CUIT ".$nrcuit." cambio su contraseña.";
						$cabeceras .= "MIME-Version: 1.0" . "\r\n";
						$cabeceras .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
						$cabeceras .= "From: U.S.I.M.R.A. <no-replay@usimra.com.ar>" . "\r\n";
						$mail = "sistemas@usimra.com.ar";
						mail($mail, $asunto, $mensaje, $cabeceras);


						$estadoResultado = "EXITO:";
						$mensajeResultado = "El cambio de clave se ha realizado correctamente. Recuerde la nueva clave para su proximo acceso al sistema.";
					} else {
						$estadoResultado = "ERROR:";
						$mensajeResultado = "Falla en el sistema. La clave no pudo ser cambiada. Intentelo nuevamente.";
						die("ERROR MYSQLI: <br>".$mysqli->error );
					}
				} 
				catch(Exception $e){
					$estadoResultado = "ERROR:";
					$mensajeResultado = "Falla en el sistema. La clave no pudo ser cambiada. Intentelo nuevamente.";
					$mysqli->rollback();
					die("ERROR MYSQLI: <br>".$e->getMessage() );
				}
			} else {
				$estadoResultado = "ERROR:";
				$mensajeResultado = "La clave actual ingresada no es correcta. Intentelo nuevamente.";
			}
		} else {
			$estadoResultado = "ERROR:";
			$mensajeResultado = "La clave nueva ingresada no debe ser igual que la clave actual. Intentelo nuevamente.";
		}
	} else {
		$estadoResultado = "ERROR:";
		$mensajeResultado = "Falla en el sistema. No se han podido tomar los datos para el cambio. Intentelo nuevamente";
	}
		
	// Cargo la plantilla
	$twig->display('resultadoCambioContrasenia.html',array("userName" => $_SESSION['userNombre'], "userRes" => $estadoResultado, "userMsg" => $mensajeResultado));
?>