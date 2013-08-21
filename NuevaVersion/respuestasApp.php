<?php session_save_path("sesiones");
session_start();
$appRespuesta = array("respuesta" => false, "mensaje" => "Error en la aplicacion", "contenido" => "");

//Verifico las variables POST y ACCION
if(isset($_POST) && !empty($_POST) && isset($_POST['accion'])) {
	include('lib/php/funcionesLogOff.php');

	if($errorDbConexion==false) {
		switch ($_POST['accion']) {
		case 'login':
			$appRespuesta['respuesta'] = userLogin($_POST, $mysqli);
			$appRespuesta['mensaje'] = "Usuario Encontrado";
//			$appRespuesta = array("respuesta" => true, "mensaje" => "Se ejecuto AJAX", "contenido" => "");
		break;
		case 'recuperaClave':
			// verifico que lleguen los campos cuit y email
			if(!empty($_POST['clave_cuit']) && !empty($_POST['clave_correo'])) {
				// Verifico que existan el usuario y la clave
				if(verificaUsuarioClave($_POST, $mysqli)) {
					if(enviaMail($_POST, $mysqli)) {
							$appRespuesta['respuesta'] = true;
							$appRespuesta['mensaje'] = "La consulta se ha realizado exitosamente. En instantes recibira su contrasenia por correo electronico";
					} else {
							$appRespuesta['mensaje'] = "No se envio la clave de acceso";
					}
				} else {
					$appRespuesta['mensaje'] = "Usuario no encontrado. Verifique los datos y reintentelo.";
				}
			}
		break;
		case 'altaEmpresa':
			// verifico que llegue el campo cuit
			if(!empty($_POST['cuit'])) {
				// Verifico si ya existe el cuit
				if(verificaCuit($_POST, $mysqli)) {
					if(guardaAlta($_POST, $mysqli)) {
							$appRespuesta['respuesta'] = true;
							$appRespuesta['mensaje'] = "El Registro se ha realizado exitosamente. Ya puede ingresar al sistema desde la seccion LOGIN";
					} else {
							$appRespuesta['mensaje'] = "El Registro no ha podido realizarse";
					}
				} else {
					$appRespuesta['mensaje'] = "C.U.I.T. ya existente. Verifique los datos y reintentelo.";
				}
			}
		break;
		default:
			$appRespuesta['mensaje'] = "Opcion No Disponible";
		break;
		}
	} else {
		$appRespuesta['mensaje'] = "Error al conectar con la base de datos";
	}
} else {
	$appRespuesta['mensaje'] = "Variables no definidas";
}
//Retorno variable en JSON
echo json_encode($appRespuesta);
?>