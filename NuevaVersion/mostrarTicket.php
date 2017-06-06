<?php session_save_path("sesiones");
session_start();
include('lib/php/verificaSesion.php');
include('lib/php/verificaConexion.php');
$root = '';
include('includes/templateEngine.inc.php');


$cuit = $_SESSION['userCuit'];
$referencia = $_GET['ref'];
$sqlConsuDDJJ = "SELECT sum(totapo)+sum(recarg) as importe FROM ddjjcondocu d, vinculadocu v WHERE v.referencia = '$referencia' and v.nrcuit = '$cuit' and v.nrctrl = d.nrctrl and v.nrcuit = d.nrcuit and d.nrcuil = '99999999999'";
if ($consuddjj = $mysqli->prepare($sqlConsuDDJJ)) {
	$consuddjj->execute();
	$consuddjj->bind_result($importeconsulta);
	while ($consuddjj->fetch()) {
		$importe = $importeconsulta;
	}
}

$twig->display('ticketTransferencia.html',array("noleidos" => $_SESSION['noleidos'], "userName" => $_SESSION['userNombre'], "cuit"=>$cuit, "referencia" => $referencia, "importe" => $importe));

?>