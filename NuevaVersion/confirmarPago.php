<?php session_save_path("sesiones");
session_start();

include('lib/php/verificaSesion.php');
include('lib/php/verificaConexion.php');
$root = '';
// Incluyo el template engine
include('includes/templateEngine.inc.php');

$nrcuit = $_SESSION['userCuit'];

//var_dump($_POST);

if(isset($_POST) && !empty($_POST) && isset($_POST['tipoPago'])) {
	if($_POST['tipoPago']=="B") {
		$ddjjs = $_POST['radioPago'];
	}
	if($_POST['tipoPago']=="T") {
		$ddjjs = $_POST['checkPago'];
	}
	$sqlConsuDDJJ = "SELECT ddjj.nrctrl, periodos.descripcion, ddjj.perano, ddjj.totapo, ddjj.recarg FROM ddjj, periodos where ddjj.nrcuit = '$nrcuit' and ddjj.nrcuil = '99999999999' and ddjj.permes = periodos.mes and ddjj.perano = periodos.anio ORDER BY ddjj.nrctrl DESC";
	if ($sentencia = $mysqli->prepare($sqlConsuDDJJ)) {
		$sentencia->execute();
		$sentencia->bind_result($control, $mes, $perano, $totapo, $recargo);
		$i = 0;
		while ($sentencia->fetch()) {
			for($j=0; $j<count($ddjjs); $j++) {
				$ddjj=$ddjjs[$j];
				if($control==$ddjj) {
					$totapo = $totapo + $recargo;
					$totapa = $totapa + $totapo;
					$totapo = number_format($totapo,2,',','.');
					$ddjjsindocu[$i] = array('control' => $control, 'permes' => $mes, 'perano' => $perano, 'totapo' => $totapo);
					$i = $i + 1;
				}
			}
		}
		$totapa = number_format($totapa,2,',','.');
	}
	//var_dump($ddjjsindocu);
	//var_dump($totapa);
	$twig->display('confirmarPago.html',array("userName" => $_SESSION['userNombre'], "tipoPago" => $_POST['tipoPago'], "ddjjsindocu" => $ddjjsindocu, "totApagar" => $totapa));
} else {
	$twig->display('accesoDirecto.html',array("userName" => $_SESSION['userNombre']));
}

?>