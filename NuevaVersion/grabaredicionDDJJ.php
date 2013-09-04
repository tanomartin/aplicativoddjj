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
$permes = $_GET['periodo'];
//echo $permes;//echo "<br>";//echo "<br>";

$activo = $_GET['ddjjactivo'];
$baja = $_GET['ddjjbaja'];
//echo $activo;//echo "<br>";
//echo $baja;//echo "<br>";

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
//echo "MOTIVO: ".$motivoRecargo;//echo "<br>";
$importeRecargo =  $datos[$limiteActivos+7];
//echo "IMPORTE: ".$importeRecargo;//echo "<br>";
$totalGeneral =  $datos[$limiteActivos+8];
//echo $totalGeneral;//echo "<br>";

$inicioBaja = $limiteActivos + 9;
$finBaja = $inicioBaja + $baja * 2;
//echo $inicioBaja;//echo "<br>";
//echo $finBaja;//echo "<br>";

//Ejecucion de la sentencia SQL
$sql = "UPDATE ddjj SET 
remune = ?, 
apo060 = ?, 
apo100 = ?, 
apo150 = ?,
totapo = ?
WHERE nrcuit = $nrcuit and nrcuil = ? and permes = $permes and perano = $perano";
//echo $sql; //echo "<br>";

$sqlTotal = "UPDATE ddjj SET 
remune = ?, 
apo060 = ?, 
apo100 = ?, 
apo150 = ?,
totapo = ?,
recarg = ?,
observ = ?
WHERE nrcuit = $nrcuit and nrcuil = '99999999999' and permes = $permes and perano = $perano";
//echo $sqlTotal; //echo "<br>";

$sqlInac = "UPDATE inactivos SET motivo = ? where nrcuit = $nrcuit and nrcuil = ? and permes = $permes and perano = $perano";
//echo $sqlInac; //echo "<br>";//echo "<br>";

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
			
			$stmt->bind_param('ddddds', $remune, $apo060, $apo100, $apo150, $totapo, $nrcuil);
			$stmt->execute();
			//print($stmt->error);//echo "<br>";
		}
		
		if ($stmt = $mysqli->prepare($sqlTotal)) {
			$stmt->bind_param('dddddds', $totalRemu, $total060, $total100, $total150, $total, $importeRecargo, $motivoRecargo);
			$stmt->execute();
			//print($stmt->error);//echo "<br>";
		}
		
		if ($stmt = $mysqli->prepare($sqlInac)) {
			for ($i=$inicioBaja; $i < $finBaja; $i++) {
				$nrcuil = $datos[$i];
				$i++;
				//echo "CUIL: ".$nrcuil;//echo "<br>";
				
				$motivo = $datos[$i];
				//echo "MOTIVO: ".$motivo;//echo "<br>";
				
				$stmt->bind_param('ss', $motivo, $nrcuil);
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
