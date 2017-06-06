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
	$tipopago = $_POST['tipoPago'];

	$consultaExtra = "SELECT anio, mes, tipo FROM extraordinarios";
	if ($sentencia = $mysqli->prepare($consultaExtra)) {
    	$sentencia->execute();
    	$sentencia->bind_result($anio, $mes, $tipo);
		$i = 0;
		while ($sentencia->fetch()) {
			$extraordinarios[$i] = array('anio' => $anio, 'mes' => $mes, 'tipo' => $tipo);
			$i = $i + 1;
    	}
	}

	$sqlConsuDDJJ = "SELECT ddjj.nrctrl, ddjj.permes, periodos.descripcion, ddjj.perano, ddjj.totapo, ddjj.recarg FROM ddjj, periodos WHERE ddjj.nrcuit = '$nrcuit' and ddjj.nrcuil = '99999999999' and ddjj.permes = periodos.mes and ddjj.perano = periodos.anio ORDER BY ddjj.nrctrl DESC";
	if ($sentencia = $mysqli->prepare($sqlConsuDDJJ)) {
		$sentencia->execute();
		$sentencia->bind_result($control, $mesextra, $mes, $perano, $totapo, $recargo);
		$i = 0;
		$totapa = 0;
		while ($sentencia->fetch()) {
			for($j=0; $j<count($ddjjs); $j++) {
				$ddjj=$ddjjs[$j];
				if($control==$ddjj) {
					$totapo = $totapo + $recargo;
					$totapa = $totapa + $totapo;
					$totapo = number_format($totapo,2,',','.');
					$mesbusca = $mesextra;
					$anobusca = $perano;

					foreach($extraordinarios as $extra) {
						if($extra['anio'] == $anobusca && $extra['mes'] == $mesbusca) {
							$tipoperi = $extra['tipo'];
							if($tipopago=="B") {
								if($tipoperi == 2) {
									$tipopago="E";
								} else {
									$tipopago="B";
								}
							}
						}
					} 

					$ddjjsindocu[$i] = array('control' => $control, 'permes' => $mes, 'perano' => $perano, 'totapo' => $totapo);
					$i = $i + 1;
				}
			}
		}
		$totapa = number_format($totapa,2,',','.');
	}
	//var_dump($ddjjsindocu);
	//var_dump($totapa);
	//var_dump($tipopago);
	$twig->display('confirmarPago.html',array("noleidos" => $_SESSION['noleidos'], "userName" => $_SESSION['userNombre'], "tipoPago" => $tipopago, "ddjjsindocu" => $ddjjsindocu, "totApagar" => $totapa));
} else {
	$twig->display('accesoDirecto.html',array("userName" => $_SESSION['userNombre']));
}

?>