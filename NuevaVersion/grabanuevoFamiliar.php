<?php session_save_path("sesiones");
session_start();
include('lib/php/verificaSesion.php');
include('lib/php/verificaConexion.php');
include('lib/php/funciones.php');

$datos = array_values($_POST);

//var_dump($datos);

$nrcuit =  $_SESSION['userCuit'];
$nrcuil =  $_GET['cuil'];

$apellido = strtoupper($datos[0]);
$nombre = strtoupper($datos[1]);
$codpar = $datos[2];
$sexo = $datos[3];
$fecnac = fechaParaGuardar($datos[4]);
$fecing = fechaParaGuardar($datos[5]);
$tipdoc = $datos[6];
$numdoc = $datos[7];
$benefi = $datos[8];
$bajada = 0;

//Ejecucion de la sentencia SQL
$sqlNuevoFamiliar = "INSERT INTO familia(nrcuit,nrcuil,nombre,apelli,codpar,ssexxo,fecnac,fecing,tipdoc,nrodoc,benefi,bajada) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";


try {
	if ($stmt = $mysqli->prepare($sqlNuevoFamiliar)) {
		$stmt->bind_param('sssssssssssi', $nrcuit, $nrcuil, $nombre, $apellido, $codpar, $sexo, $fecnac, $fecing, $tipdoc, $numdoc, $benefi, $bajada);
		
		$stmt->execute();
		$stmt->close();
		
		$pagina = "perfilEmpleado.php?cuil=$nrcuil";
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
