<?php session_save_path("sesiones");
session_start();

include('lib/php/verificaSesion.php');
include('lib/php/verificaConexion.php');
include('lib/php/funciones.php');
require('lib/php/fpdf.php');

$root = '';
// Incluyo el template engine
include('includes/templateEngine.inc.php');

$cuit = $_SESSION['userCuit'];
//$referencia = date("ymdHis");
$referencia = date_format(date_create(), 'U');

if(isset($_POST) && !empty($_POST) && isset($_POST['tipoPago']) && isset($_POST['nrctrl'])) {
	$instrumento = $_POST['tipoPago'];
	
	if (strcmp($_POST['tipoPago'],'E') == 0) {
		$instrumento = 'B';
	}
	
	$ddjjs = $_POST['nrctrl'];
	for($i=0; $i<count($ddjjs); $i++) {
		$ddjj=$ddjjs[$i];
		$sqlConsuDDJJ = "SELECT * FROM ddjj WHERE nrcuit = '$cuit' and nrctrl = '$ddjj'";
		if ($consuddjj = $mysqli->prepare($sqlConsuDDJJ)) {
   			$consuddjj->execute();
   			$consuddjj->bind_result($id, $nrcuit, $nrcuil, $permes, $perano, $remune, $apo060, $apo100, $apo150, $totapo, $recarg, $nfilas, $controldj, $observ);
			$j = 0;
			while($consuddjj->fetch()) {
				$ddjjsdocu[$j] = array('idsd' => $id, 'nrcuitsd' => $nrcuit, 'nrcuilsd' => $nrcuil, 'permessd' => $permes, 'peranosd' => $perano, 'remunesd' => $remune,'apo060sd' => $apo060, 'apo100sd' => $apo100, 'apo150sd' => $apo150, 'totaposd' => $totapo, 'recargsd' => $recarg, 'nfilassd' => $nfilas, 'controldjsd' => $controldj, 'observsd' => $observ);
				$j = $j + 1;
   			}
		}

		for($j=0; $j<count($ddjjsdocu); $j++) {
			$sqlPasaDDJJ = "INSERT INTO ddjjcondocu(id,nrcuit,nrcuil,permes,perano,remune,apo060,apo100,apo150,totapo,recarg,nfilas,instrumento,nrctrl,observ,bajada) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			try {
				if ($pasaddjj = $mysqli->prepare($sqlPasaDDJJ)) {
					$bajada = 0;
					$pasaddjj->bind_param('issiiddddddisssi', $ddjjsdocu[$j]['idsd'], $ddjjsdocu[$j]['nrcuitsd'], $ddjjsdocu[$j]['nrcuilsd'], $ddjjsdocu[$j]['permessd'], $ddjjsdocu[$j]['peranosd'], $ddjjsdocu[$j]['remunesd'], $ddjjsdocu[$j]['apo060sd'], $ddjjsdocu[$j]['apo100sd'], $ddjjsdocu[$j]['apo150sd'], $ddjjsdocu[$j]['totaposd'], $ddjjsdocu[$j]['recargsd'], $ddjjsdocu[$j]['nfilassd'], $instrumento, $ddjjsdocu[$j]['controldjsd'], $ddjjsdocu[$j]['observsd'], $bajada);
					$pasaddjj->execute();
					$pasaddjj->close();
				} else {
					die("ERROR MYSQLI: <br>".$mysqli->error );
				}
			} 
			catch(Exception $e){
				$mysqli->rollback();
				die("ERROR MYSQLI: <br>".$e->getMessage() );
			}
		}
	
		for($j=0; $j<count($ddjjsdocu); $j++) {
			if(strcmp($ddjjsdocu[$j]['nrcuilsd'],'99999999999') == 0) {
				if (strcmp($instrumento,'T') == 0) {
					$sqlVinculaDDJJ = "INSERT INTO vinculadocu(nrcuit, referencia, nrctrl) VALUES(?,?,?)";
					try {
						if ($vinculaddjj = $mysqli->prepare($sqlVinculaDDJJ)) {
							$vinculaddjj->bind_param('sss', $cuit, $referencia, $ddjjsdocu[$j]['controldjsd']);
							$vinculaddjj->execute();
							$vinculaddjj->close();
						} else {
							die("ERROR MYSQLI: <br>".$mysqli->error );
						}
					} 
					catch(Exception $e){
						$mysqli->rollback();
						die("ERROR MYSQLI: <br>".$e->getMessage() );
					}
				}
			}
		}
	
		for($j=0; $j<count($ddjjsdocu); $j++) {
			$sqlBorraDDJJ = "DELETE FROM ddjj WHERE nrcuit = ? and nrctrl = ?";
			try {
				if ($borraddjj = $mysqli->prepare($sqlBorraDDJJ)) {
					$borraddjj->bind_param('ss', $ddjjsdocu[$j]['nrcuitsd'], $ddjjsdocu[$j]['controldjsd']);
					$borraddjj->execute();
					$borraddjj->close();
				} else {
					die("ERROR MYSQLI: <br>".$mysqli->error );
				}
			} 
			catch(Exception $e){
				$mysqli->rollback();
				die("ERROR MYSQLI: <br>".$e->getMessage() );
			}
		}
	}

	$sqlEmpresa = "SELECT * FROM empresa WHERE nrcuit = '$cuit'";
	$resEmpresa = $mysqli -> query($sqlEmpresa);
	$datEmpresa = $resEmpresa -> fetch_assoc();
	
	$empresa = (object) array('nrcuit' => $datEmpresa['nrcuit'], 'nombre' => $datEmpresa['nombre'], 'domicilio' => $datEmpresa['domile'], 'localidad' => $datEmpresa['locali']);
	
	$sqlConsuConDocu = "SELECT ddjjcondocu.nrctrl, ddjjcondocu.permes, periodos.descripcion, ddjjcondocu.perano, ddjjcondocu.nfilas, ddjjcondocu.remune, ddjjcondocu.recarg, ddjjcondocu.apo060, ddjjcondocu.apo100, ddjjcondocu.apo150, ddjjcondocu.totapo FROM ddjjcondocu, periodos WHERE ddjjcondocu.nrcuit = '$cuit' and ddjjcondocu.nrcuil = '99999999999' and ddjjcondocu.instrumento = '$instrumento' and ddjjcondocu.permes = periodos.mes and ddjjcondocu.perano = periodos.anio ORDER BY ddjjcondocu.perano, ddjjcondocu.permes";
	if ($consucondocu = $mysqli->prepare($sqlConsuConDocu)) {
		$consucondocu->execute();
		$consucondocu->bind_result($controlcd, $mescd, $descrimescd, $peranocd, $nfilascd, $remunecd, $recargcd, $apo060cd, $apo100cd, $apo150cd, $totapocd);
		$i = 0;
		$totapa = 0;
		while ($consucondocu->fetch()) {
			for($j=0; $j<count($ddjjs); $j++) {
				$ddjj=$ddjjs[$j];
				if($controlcd==$ddjj) {
					$totapocd = $totapocd + $recargcd;
					$totapa = $totapa + $totapocd;
					$totapocd = number_format($totapocd,2,',','.');
					$ddjjcdocu[$i] = array('control' => $controlcd, 'permes' => $mescd, 'descrimes' => $descrimescd = str_replace("Cuota","",$descrimescd), 'perano' => $peranocd, 'nfilas' => $nfilascd, 'remune' => number_format($remunecd,2,',','.'), 'recarg' => number_format($recargcd,2,',','.'), 'apo060' => number_format($apo060cd,2,',','.'), 'apo100' => number_format($apo100cd,2,',','.'), 'apo150' => number_format($apo150cd,2,',','.'), 'totapo' => $totapocd);
					$i = $i + 1;
				}
			}
		}
		$numeroLetras = strtoupper(cfgValorEnLetras($totapa));
		$totapa = number_format($totapa,2,',','.');
	}
	
	if (strcmp($_POST['tipoPago'],'T') == 0) {
		$sqlConsuVincula = "SELECT referencia, nrctrl FROM vinculadocu WHERE nrcuit = '$cuit'";
		if ($consuvincula = $mysqli->prepare($sqlConsuVincula)) {
			$consuvincula->execute();
			$consuvincula->bind_result($referenciav, $controlv);
			$i = 0;
			while ($consuvincula->fetch()) {
				for($j=0; $j<count($ddjjs); $j++) {
					$ddjj=$ddjjs[$j];
					if($controlv==$ddjj) {
						$vinculadocu[$i] = array('referencia' => $referenciav, 'control' => $controlv);
						$i = $i + 1;
					}
				}
			}
		}
	}
	
	if (strcmp($_POST['tipoPago'],'B') == 0) {
		$nota[0] = ("1 - Original: Para el DEPOSITANTE");
		$nota[1] = ("2 - Duplicado: Para el BANCO como comprobante de Caja");
		//$nota[2] = ("3 - Triplicado: XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX");
		
		for($j=0; $j<count($ddjjs); $j++) {
			$nrctrlh=$ddjjs[$j];
		}
	
		$nconvenio = 3617;
		$ncuasifinal = $nconvenio.$cuit.$nrctrlh;
		$npart3total = 0;
		$npart1total = 0;
		for ($i=0; $i < 29; $i++) {
			$npor3 = substr($ncuasifinal,$i,1);
			$npor33 = $npor3 * 3;
			$npart3total = $npart3total + $npor33;
			$i = $i + 1;
			$npor1 = substr($ncuasifinal,$i,1);
			$npart1total = $npart1total + $npor1;
		}
		$npartot = $npart1total + $npart3total;
		$largonpar = strlen($npartot);
		$ndigito = $largonpar -1;
		$nverifi01 = substr($npartot,$ndigito,1);
		
		if ($nverifi01 == 0) {
			$dverifi = 0;
		} else {
			$dverifi = 10 - $nverifi01;
		}
		
		$codigobarra = $ncuasifinal.$dverifi;
		for($i=0; $i < strlen($codigobarra); $i++) {
			$archivosbarra[$i] =  $codigobarra[$i].".jpg";
		}
	}
	
	if (strcmp($_POST['tipoPago'],'E') == 0) {
		$nota[0] = 1;
		$nota[1] = 2;
		//$nota[2] = 3;
		
		for($j=0; $j<count($ddjjs); $j++) {
			$nrctrlh=$ddjjs[$j];
		}
		//$importe = str_pad($totapa, 11, '0', STR_PAD_LEFT);
		$importe = str_replace(",","",$totapa);
		$importe = str_replace(".","",$importe);
		$importe = str_pad($importe, 9, '0', STR_PAD_LEFT);

		$nconvenio = 5866;
		$ncuasifinal = $nconvenio.$cuit.$nrctrlh.$importe;
		$npart3total = 0;
		$npart1total = 0;
		for ($i=0; $i < 38; $i++) {
			$npor3 = substr($ncuasifinal,$i,1);
			$npor33 = $npor3 * 3;
			$npart3total = $npart3total + $npor33;
			$i = $i + 1;
			$npor1 = substr($ncuasifinal,$i,1);
			$npart1total = $npart1total + $npor1;
		}
		$npartot = $npart1total + $npart3total;
		$largonpar = strlen($npartot);
		$ndigito = $largonpar -1;
		$nverifi01 = substr($npartot,$ndigito,1);
		
		if ($nverifi01 == 0) {
			$dverifi = 0;
		} else {
			$dverifi = 10 - $nverifi01;
		}
		
		$codigobarra = $ncuasifinal.$dverifi;
	}
	//var_dump($totapa);
	//var_dump($importe);
	//var_dump($empresa);
	//var_dump($ddjjcdocu);
	//var_dump($totapa);
	//var_dump($numeroLetras);
	//var_dump($vinculadocu);
	//var_dump($nota);
	//var_dump($codigobarra);
	//var_dump($archivosbarra);
	
	if (strcmp($_POST['tipoPago'],'B') == 0) {
		$twig->display('boletaDeposito.html',array("userName" => $_SESSION['userNombre'], "tipoPago" => $instrumento, "datosEmpresa" => $empresa, "ddjjCDocu" => $ddjjcdocu, "totApagar" => $totapa, "impLetras" => $numeroLetras, "ddjjVincu" => $vinculadocu, "canBoleta" => $nota, "codBar" => $codigobarra, "archBar" => $archivosbarra));
	} 
	if (strcmp($_POST['tipoPago'],'E') == 0) {
		$twig->display('boletaDepositoExtra.html',array("userName" => $_SESSION['userNombre'], "tipoPago" => $instrumento, "datosEmpresa" => $empresa, "ddjjCDocu" => $ddjjcdocu, "totApagar" => $totapa, "impLetras" => $numeroLetras, "ddjjVincu" => $vinculadocu, "canBoleta" => $nota, "codBar" => $codigobarra));
	} 
	if (strcmp($instrumento,'T') == 0) {
		header('Location: mostrarTicket.php?ref='.$referencia.'&imp='.$totapa);
	}
} else {
	$twig->display('accesoDirecto.html',array("userName" => $_SESSION['userNombre']));
}


?>