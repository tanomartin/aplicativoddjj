<?php session_save_path("sesiones");
session_start();

include('lib/php/verificaSesion.php');
include('lib/php/verificaConexion.php');
$root = '';
// Incluyo el template engine
include('includes/templateEngine.inc.php');


	$nrcuit = $_SESSION['userCuit'];
	$consultaDDJJ = "SELECT permes, perano, totapo FROM ddjj where nrcuit = $nrcuit and nrcuil = '99999999999' order by nrctrl DESC limit 6";
	if ($sentencia = $mysqli->prepare($consultaDDJJ)) {
    	$sentencia->execute();
    	$sentencia->bind_result($permes, $perano, $totapo);
		$i = 0;
		while ($sentencia->fetch()) {
			$ddjjsindocu[$i] = array('permes' => $permes, 'perano' => $perano, 'totapo' => $totapo);
			$i = $i + 1;
    	}
	}

//var_dump($ddjjsindocu);

$twig->display('opcionesDDJJ.html',array("userName" => $_SESSION['userNombre'], "ddjjsindocu" => $ddjjsindocu));

?>