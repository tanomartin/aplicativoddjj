<?php session_save_path("sesiones");
session_start();

include('lib/php/verificaSesion.php');
include('lib/php/verificaConexion.php');
$root = '';
// Incluyo el template engine
include('includes/templateEngine.inc.php');

$nrcuit = $_SESSION['userCuit'];

//*******************************************************************//
//********************* VALIDAS **************************************//
//*******************************************************************//
$consultaValidas = "
SELECT 
validas.nrctrl, validas.permes ,periodos.descripcion, validas.perano, validas.totapo , validas.recarg ,validas.instrumento
FROM 
validas, periodos 
WHERE 
validas.nrcuit = $nrcuit and 
validas.nrcuil = '99999999999' and 
periodos.mes = validas.permes and
periodos.anio = validas.perano
order by validas.nrctrl DESC limit 6";

//print($consultaValidas);

if ($sentencia = $mysqli->prepare($consultaValidas)) {
    $sentencia->execute();
    $sentencia->bind_result($control, $permes, $mes, $perano, $totapo, $recargo, $documento);
	$i = 0;
	while ($sentencia->fetch()) {
		$totapo = $totapo + $recargo;
		$totapo = number_format($totapo,2,',','.');
		$ddjjvalidas[$i] = array('control' => $control, 'mescod' => $permes, 'permes' => $mes, 'perano' => $perano, 'totapo' => $totapo, 'instrumento' => $documento);
		$i = $i + 1;
   	}
}

for($i=0; $i < sizeof($ddjjvalidas); $i++) {
	$instrum = $ddjjvalidas[$i]['instrumento'];
	$nrocontrol = $ddjjvalidas[$i]['control'];
	if (strcmp($instrum,'T') == 0) {
		$consRef = "SELECT referencia FROM vinculadocu WHERE nrctrl = $nrocontrol";
		$respRef = $mysqli -> query($consRef);
		$refData = $respRef -> fetch_assoc();
		$ddjjvalidas[$i]['instrumento'] = $instrum."-".$refData['referencia'];
	}
	if (strcmp($instrum,'B') == 0) {
		$ddjjvalidas[$i]['instrumento'] = $instrum."-".$nrocontrol;
	}
}

$twig->display('ddjjvalidas.html',array("userName" => $_SESSION['userNombre'], "ddjjvalidas" => $ddjjvalidas));

?>