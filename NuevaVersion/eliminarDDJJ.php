<?php session_save_path("sesiones");
session_start();
include('lib/php/verificaSesion.php');
include('lib/php/verificaConexion.php');
$root = '';
// Incluyo el template engine
include('includes/templateEngine.inc.php');

$nrcuit = $_SESSION['userCuit'];
if (isset($_GET['control'])) {
	$nrcontrol = $_GET['control'];
	$sql = "DELETE from ddjj where nrcuit = ? and nrctrl = ?";
	$sqlInactivos = "DELETE from inactivos where nrcuit = ? and nrctrl = ?";
	
	try {
		if ($stmt = $mysqli->prepare($sql)) {
			$stmt->bind_param('ss', $nrcuit, $nrcontrol);
			$stmt->execute();
			//print($stmt->error);echo "<br>";
			$stmt->close();
			if ($stmt = $mysqli->prepare($sqlInactivos)) {
				$stmt->bind_param('ss', $nrcuit, $nrcontrol);
				$stmt->execute();
				//print($stmt->error);echo "<br>";
				$stmt->close();
				$pagina = "opcionesDDJJ.php";
				Header("Location: $pagina"); 
			} 
		} 
	} 
	catch(Exception $e){
		$mysqli->rollback();
		die("ERROR MYSQLI: <br>".$e->getMessage() );
	}
} else {
	$twig->display('accesoDirecto.html',array("userName" => $_SESSION['userNombre']));
}
?>
