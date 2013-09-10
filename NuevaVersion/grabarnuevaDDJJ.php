<?php session_save_path("sesiones");
session_start();
include('lib/php/verificaSesion.php');
include('lib/php/verificaConexion.php');

$nrcuit = $_SESSION['userCuit'];
//echo $nrcuit;//echo "<br>";
$datos = array_values($_POST);

//var_dump($datos);
$perano = $datos[0];
//echo $perano;//echo "<br>";

if (isset($_GET['permes'])) {
	$permes =$_GET['permes'];
} else {
	$permes = $datos[1];
}
//echo $permes;//echo "<br>";//echo "<br>";

$nrctrl =  date("YmdHis");
//echo $nrctrl;//echo "<br>";

$activo = $_GET['activo'];
$baja = $_GET['baja'];
//echo "ACTIVOS: ".$activo; //echo "<br>";
//echo "BAJA: ".$baja; //echo "<br>";

$limiteActivos = 2 + $activo * 7;
//echo $limiteActivos;//echo "<br>";

$totalRemu = $datos[$limiteActivos];
$totalAlic = $datos[$limiteActivos+1];
if ($totalRemu == 0) {
	$totalRemu = $totalAlic;
}
$total060 = $datos[$limiteActivos+2];
$total100 = $datos[$limiteActivos+3];
$total150 = $datos[$limiteActivos+4];
$total = $datos[$limiteActivos+5];

$motivoRecargo =  $datos[$limiteActivos+6];
//echo $motivoRecargo;//echo "<br>";
$importeRecargo =  $datos[$limiteActivos+7];
//echo $importeRecargo;//echo "<br>";
$totalGeneral =  $datos[$limiteActivos+8];
//echo $totalGeneral;//echo "<br>";

$inicioBaja = $limiteActivos + 9;
$finBaja = $inicioBaja + $baja * 2;
//echo $inicioBaja;//echo "<br>";
//echo $finBaja;//echo "<br>";

//Ejecucion de la sentencia SQL
$sql = "INSERT INTO ddjj (nrcuit,nrcuil,permes,perano,remune,apo060,apo100,apo150,totapo,recarg,nfilas,nrctrl,observ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
$sqlInac = "INSERT INTO inactivos (nrcuit,nrcuil,permes,perano,motivo,nrctrl) VALUES (?,?,?,?,?,?)";

try {
	if ($stmt = $mysqli->prepare($sql)) {
		for ($i=2; $i < $limiteActivos; $i++) {
			$nrcuil = $datos[$i];
			$i++;
			//echo "CUIL: ".$nrcuil;//echo "<br>";
			
			$remune = $datos[$i];
			$i++;
			//echo "Remu: ".$remune;//echo "<br>";
			
			$alicuo = $datos[$i];
			$i++;
			//echo "Alicuo: ".$alicuo;//echo "<br>";
			if ($alicuo != 0) {
				$remune = $alicuo;
			}
			
			$apo060 = $datos[$i];
			$i++;
			//echo "60: ".$apo060;//echo "<br>";
			
			$apo100 = $datos[$i];
			$i++;
			//echo "100: ".$apo100;//echo "<br>";
			
			$apo150 = $datos[$i];
			$i++;
			//echo "150: ".$apo150;//echo "<br>";
			
			$totapo = $datos[$i];
			//echo "TotalEmp: ".$totapo;//echo "<br>";
			
			$recarg = 0;
			//echo "recarg: ".$recarg;//echo "<br>";
			
			$nfilas = 0;
			//echo "nfilas: ".$nfilas;//echo "<br>";
			
			$observ = '';
			//echo "observ: ".$observ;//echo "<br>";//echo "<br>";
			
			$stmt->bind_param('ssiiddddddiss', $nrcuit, $nrcuil, $permes, $perano, $remune, $apo060, $apo100, $apo150, $totapo, $recarg, $nfilas, $nrctrl, $observ);
			$stmt->execute();
			//print($stmt->error);//echo "<br>";
		}
		
		$nrcuil = '99999999999';	
		$stmt->bind_param('ssiiddddddiss', $nrcuit, $nrcuil, $permes, $perano, $totalRemu, $total060, $total100, $total150, $total, $importeRecargo, $activo, $nrctrl, $motivoRecargo);
		$stmt->execute();
		//print($stmt->error);//echo "<br>";
		
		if ($stmt = $mysqli->prepare($sqlInac)) {
			for ($i=$inicioBaja; $i < $finBaja; $i++) {
				$nrcuil = $datos[$i];
				$i++;
				//echo "CUIL: ".$nrcuil;//echo "<br>";
				
				$motivo = $datos[$i];
				//echo "MOTIVO: ".$motivo;//echo "<br>";
				
				$stmt->bind_param('ssiiss', $nrcuit, $nrcuil, $permes, $perano, $motivo, $nrctrl);
				$stmt->execute();
				//print($stmt->error);//echo "<br>";
			}
		}
		
		$stmt->close();
		$pagina = "opcionesDDJJ.php";
		Header("Location: $pagina"); 
	} else {
		 die("ERROR MYSQLI: <br>".$mysqli->error );
	}
	
} 
catch(Exception $e){
    $mysqli->rollback();
    die("ERROR MYSQLI: <br>".$e->getMessage() );
}

?>
