<?php
$datos = array_values($_POST);

$mail = $datos [0];
$nrcuit = $datos [1];

include ("lib/conexion.php");

$sql = "select * from empresa where nrcuit = '$nrcuit' and emails = '$mail'";
$result = mysql_query($sql,$db);
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


