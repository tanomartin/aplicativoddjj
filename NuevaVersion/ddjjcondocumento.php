<?php session_save_path("sesiones");
session_start();

include('lib/php/verificaSesion.php');
include('lib/php/verificaConexion.php');
$root = '';
// Incluyo el template engine
include('includes/templateEngine.inc.php');

$nrcuit = $_SESSION['userCuit'];

//*******************************************************************//
//********************* CON DOCU **************************************//
//*******************************************************************//
$consultaDDJJconDocu = "
SELECT 
ddjjcondocu.nrctrl, periodos.descripcion, ddjjcondocu.perano, ddjjcondocu.totapo, ddjjcondocu.recarg, ddjjcondocu.instrumento
FROM 
ddjjcondocu, periodos 
WHERE 
ddjjcondocu.nrcuit = $nrcuit and 
ddjjcondocu.nrcuil = '99999999999' and 
periodos.mes = ddjjcondocu.permes and
periodos.anio = ddjjcondocu.perano
order by ddjjcondocu.nrctrl DESC";

if ($sentencia = $mysqli->prepare($consultaDDJJconDocu)) {
    $sentencia->execute();
    $sentencia->bind_result($control, $mes, $perano, $totapo, $recargo, $documento);
	$i = 0;
	while ($sentencia->fetch()) {
		$totapo = $totapo + $recargo;
		$totapo = number_format($totapo,2,',','.');
		$ddjjcondocu[$i] = array('control' => $control, 'permes' => $mes, 'perano' => $perano, 'totapo' => $totapo, 'instrumento' => $documento);
		$i = $i + 1;
   	}
}

for($i=0; $i < sizeof($ddjjcondocu); $i++) {
	$instrum = $ddjjcondocu[$i]['instrumento'];
	$nrocontrol = $ddjjcondocu[$i]['control'];
	if (strcmp($instrum,'T') == 0) {
		$consRef = "SELECT referencia FROM vinculadocu WHERE nrctrl = $nrocontrol and nrcuit = $nrcuit";
		$respRef = $mysqli -> query($consRef);
		$refData = $respRef -> fetch_assoc();
		$ddjjcondocu[$i]['nroinstrumento'] = $refData['referencia'];
	}
	if (strcmp($instrum,'B') == 0) {
		$ddjjcondocu[$i]['nroinstrumento'] = $nrocontrol;
	}
}

$twig->display('ddjjcondocumento.html',array("userName" => $_SESSION['userNombre'], "ddjjcondocu" => $ddjjcondocu));

?>