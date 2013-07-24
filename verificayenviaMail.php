<?
/*
if (count($_POST) == 0){
						header ('location:login.htm');
						exit(); //sale del php y n hace mas nada
						}
*/
$datos = array_values($HTTP_POST_VARS);

$mail = $datos [0];
$nrcuit = $datos [1];

include ("lib/conexion.php");

$sql = "select * from empresa where nrcuit = '$nrcuit' and emails = '$mail'";
$result = mysql_db_query("uv0472_aplicativo",$sql,$db);
$cant = mysql_num_rows($result);
if ($cant > 0) {

	$row=mysql_fetch_array($result);
	$asunto = "Recordatorio de Contraseña del sitio www.usimra.com.ar";
	
	// mensaje
	$mensaje = $row['nombre'].": " . "\r\n";
	$mensaje .= "La contraseña requerida del usuario ".$nrcuit." es ".$row['claveacc']." .";
	
	// Para enviar correo HTML, la cabecera Content-type debe definirse
	$cabeceras .= "MIME-Version: 1.0" . "\r\n";
	$cabeceras .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
	
	// Cabeceras adicionales
	//$cabeceras .= $mail. "\r\n";
	$cabeceras .= "From: U.S.I.M.R.A. <no-replay@usimra.com.ar>" . "\r\n";
	$cabeceras .= 'Bcc: sistemas@usimra.com.ar' . "\r\n";
	//$cabeceras .= 'Bcc: chequeo@example.com' . "\r\n";
	
	// Enviarlo
	mail($mail, $asunto, $mensaje, $cabeceras);
	
	header ('location:pedidoContrasenia.php?err=2');
	} else {
		header ('location:pedidoContrasenia.php?err=1');
	}
?>


