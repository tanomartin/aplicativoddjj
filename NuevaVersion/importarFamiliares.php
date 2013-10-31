<?php session_save_path("sesiones");
session_start();
	
	include('lib/php/verificaSesion.php');
	include('lib/php/verificaConexion.php');
	include('lib/php/verificaMgr.php');
	$root = '';
	// Incluyo el template engine
	include('includes/templateEngine.inc.php');

	//print("LALAL");
	
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
	
	function formatoEstado($campo) {
		if ($campo == "S") {
			return "SI";
		} else {
			return "NO";
		}
	}
	
	function formatoPare($campo) {
		if ($campo == 1) {
			return "CONYUGE";
		}
		if ($campo == 2) {
			return "CONCUBINO";
		}
		if ($campo == 3) {
			return "FAMILIAR A CARGO";
		}
		if ($campo == 4) {
			return "HIJO";
		}
	}
	
	$cuit=$_SESSION['userCuit'];
	$nombreArc="fam-".$cuit.".txt";
	$archivoHost="modulog/archivos/$cuit/$nombreArc";
	$registros = file($archivoHost, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	for($i = 0; $i < count($registros); $i++) {
		$campos=explode("|", $registros[$i]);
		
		$campos[4]=formatoPare($campos[4]);
		$campos[5]=formatoSexo($campos[5]);
		$campos[8]=formatoTipoDoc($campos[8]);
		$campos[9]=(int)$campos[9];
		$campos[10]=formatoEstado($campos[10]);
		$bajada = 0;
		$sqlNuevoFamiliar = "INSERT INTO familia(nrcuit,nrcuil,nombre,apelli,codpar,ssexxo,fecnac,fecing,tipdoc,nrodoc,benefi,bajada) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
		
		try {
			if ($stmt = $mysqli->prepare($sqlNuevoFamiliar)) {
				$stmt->bind_param('sssssssssssi', trim($campos[0]),trim($campos[1]),trim(strtoupper($campos[2])), trim(strtoupper($campos[3])), trim($campos[4]), trim($campos[5]), trim($campos[6]), trim($campos[7]), trim($campos[8]), trim($campos[9]), trim($campos[10]), $bajada);
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
	Header("Location: $pagina"); 
?>
