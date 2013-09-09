<?php session_save_path("sesiones");
session_start();

include('lib/php/verificaSesion.php');
include('lib/php/verificaConexion.php');
$root = '';
// Incluyo el template engine
include('includes/templateEngine.inc.php');

$nrcuit = $_SESSION['userCuit'];

//*******************************************************************//
//********************* SIN DOCU **************************************//
//*******************************************************************//
$consultaDDJJ = "SELECT ddjj.nrctrl, periodos.descripcion, ddjj.perano, ddjj.totapo, ddjj.recarg FROM ddjj, periodos where ddjj.nrcuit = $nrcuit and ddjj.nrcuil = '99999999999' and periodos.mes = ddjj.permes and periodos.anio = ddjj.perano order by ddjj.nrctrl DESC limit 6";
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
order by ddjjcondocu.nrctrl DESC limit 6";

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
		$consRef = "SELECT referencia FROM vinculadocu WHERE nrctrl = $nrocontrol";
		$respRef = $mysqli -> query($consRef);
		$refData = $respRef -> fetch_assoc();
		$ddjjcondocu[$i]['instrumento'] = $instrum."-".$refData['referencia'];
	}
	if (strcmp($instrum,'B') == 0) {
		$ddjjcondocu[$i]['instrumento'] = $instrum."-".$nrocontrol;
	}
}


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

//var_dump($ddjjsindocu);
//var_dump($ddjjvalidas);

$twig->display('opcionesDDJJ.html',array("userName" => $_SESSION['userNombre'], "ddjjsindocu" => $ddjjsindocu, "ddjjcondocu" => $ddjjcondocu, "ddjjvalidas" => $ddjjvalidas));

?>