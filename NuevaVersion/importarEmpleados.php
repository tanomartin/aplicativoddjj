<?php session_save_path("sesiones");
session_start();
	include('lib/php/verificaSesion.php');
	include('lib/php/verificaConexion.php');
	include('lib/php/verificaMgr.php');
	$root = '';
	// Incluyo el template engine
	include('includes/templateEngine.inc.php');

	function formatoSexo($campo) {
		if ($campo == "F") {
			return "FEMENINO";
		} else {
			return "MASCULINO";
		}
	}
	
	function formatoTipoDoc($campo) {
		if ($campo==1){
			return "DNI";
		}
		if ($campo==2){
			return "LE";
		}
		if ($campo==3){
			return "LC";
		}
		if ($campo==4){
			return "CI";
		}
	}
	
	function formatoEC($campo) {
		if ($campo==1) {
			return "SOLTERO";
		}
		if ($campo==2) {
			return "CASADO";
		}
		if ($campo==3) {
			return "SEPARADO";
		}
		if ($campo==4) {
			return "DIVORCIADO";
		}
		if ($campo==5) {
			return "VIUDO";
		}	
	}
	
	function formatoNum($campo) {
		return (int)$campo;
	}
	
	function formatoEstado($campo) {
		if ($campo == "S") {
			return "SI";
		} else {
			return "NO";
		}
	}
	
	$cuit=$_SESSION['userCuit'];
	$nombreArc="emp-".$cuit.".txt";
	$archivoHost="modulog/archivos/$cuit/$nombreArc";
	$registros = file($archivoHost, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	for($i = 0; $i < count($registros); $i++) {
		$campos=explode("|", $registros[$i]);
		
		//TODO ---> pasar a mayuscula todo...???
		
		$campos[5]=formatoTipoDoc($campos[5]);
		$campos[6]=(int)$campos[6];
		$campos[7]=formatoSexo($campos[7]);
		$campos[9]=formatoEC($campos[9]);
		$campos[13]=formatoNum($campos[13]);
		$campos[15]=formatoNum(substr($campos[15],3,3));
		$campos[16]=formatoEstado($campos[16]);
		$bajada = 0;
		
		//Ejecucion de la sentencia SQL
		$sqlNuevoEmpleado = "INSERT INTO empleados(nrcuit,nrcuil,apelli,nombre,fecing,tipdoc,nrodoc,ssexxo,fecnac,estciv,direcc,locale,copole,provin,nacion,catego,activo,bajada) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		
		try {
			if ($stmt = $mysqli->prepare($sqlNuevoEmpleado)) {
				$stmt->bind_param('sssssssssssssssssi', trim($campos[0]),trim($campos[1]), trim(strtoupper($campos[2])), trim(strtoupper($campos[3])), trim($campos[4]), trim($campos[5]), trim($campos[6]),  trim($campos[7]), trim($campos[8]), trim($campos[9]) ,trim(strtoupper($campos[10])), trim(strtoupper($campos[11])), trim($campos[12]), trim($campos[13]), trim(strtoupper($campos[14])), trim($campos[15]), trim($campos[16]),$bajada);
				$stmt->execute();
				$stmt->close();
			} else {
				 die("ERROR MYSQLI: <br>".$mysqli->error );
			}
		} 
		catch(Exception $e){
			$mysqli->rollback();
			die("ERROR MYSQLI: <br>".$e->getMessage() );
		}
	}	
	
	$pagina = "listaEmpleados.php";
	Header("Location: $pagina")
?>