<?php session_save_path("sesiones");
session_start();

include('lib/php/verificaSesion.php');
include('lib/php/verificaConexion.php');
$root = '';
// Incluyo el template engine
include('includes/templateEngine.inc.php');

$nrcuit = $_SESSION['userCuit'];

$ddjjsindocu = array();
//*******************************************************************//
//********************* SIN DOCU ************************************//
//*******************************************************************//
$consultaDDJJ = "SELECT ddjj.nrctrl, periodos.descripcion, ddjj.perano, ddjj.totapo, ddjj.recarg FROM ddjj, periodos where ddjj.nrcuit = $nrcuit and ddjj.nrcuil = '99999999999' and ddjj.permes = periodos.mes and ddjj.perano = periodos.anio ORDER BY ddjj.nrctrl DESC";
if ($sentencia = $mysqli->prepare($consultaDDJJ)) {
    $sentencia->execute();
    $sentencia->bind_result($control, $mes, $perano, $totapo, $recargo);
	$i = 0;
	while ($sentencia->fetch()) {
		$totapo = $totapo + $recargo;
		$totapo = number_format($totapo,2,',','.');
		$ddjjsindocu[$i] = array('control' => $control, 'permes' => $mes, 'perano' => $perano, 'totapo' => $totapo);
		$i = $i + 1;
   	}
}

$twig->display('opcionesPago.html',array("noleidos" => $_SESSION['noleidos'], "userName" => $_SESSION['userNombre'], "ddjjsindocu" => $ddjjsindocu));
?>