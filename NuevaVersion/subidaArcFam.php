<?php session_save_path("sesiones");
session_start();

include('lib/php/verificaSesion.php');
include('lib/php/verificaConexion.php');
include('lib/php/verificaMgr.php');
$root = '';
// Incluyo el template engine
include('includes/templateEngine.inc.php');
	
$archivo = $_FILES['archivo'];	
$archivo_name = $archivo['name'];
$archivo_type = $archivo['type'];
//print("NOMBRE ARCHIVO:". $archivo['name']."<br/>\n");

function controlarNombreArc($nombre,$type,$mysqli) {
	//print("MODULO CONTROL NOMBRE<br/>\n");
	$ext="text";
	$long=strlen($nombre);
	//print("TIPO= $type vs $ext <br/>\n");
	//print ("LONGITUD: $long <br/>\n");
	if (strlen($nombre) == 19) {
		$inicio=substr($nombre,0,4);
		//print ("INICIO: $inicio <br/>\n");
		$ncuit=substr($nombre,4,11);
		//print ("CUIT: $ncuit <br/>\n");
		if (strcmp($inicio,"FAM-")) {
			if (strpos($type, $ext) !== false) {
				$sql = "select * from empresa where nrcuit = $ncuit";
				if ($sentencia = $mysqli->prepare($sql)) {
					$sentencia->execute();
					$sentencia->store_result();
					$cant = $sentencia->num_rows;
					//controlo que exista la empresa y que el cuit concuerde con la sesion
					if (($cant == 1) && ($ncuit == $_SESSION['userCuit'])){
						return 0;
					} else {
						return array(21,"Error CUIT en nombre de archivo inexistente");
					}
				} else {
					return array(20,"Error nombre de archivo (EMP-nrocuit.txt)");
				}
			} else {
				return array(20,"Error nombre de archivo (EMP-nrocuit.txt)");
			}
		} else {
			return array(20,"Error nombre de archivo (EMP-nrocuit.txt)");
		}
	} else {
		return array(20,"Error nombre de archivo (EMP-nrocuit.txt)");
	} 
}

function verificaBlancos($campo,$largo) {
	$ok=1;
	for($i = 0; $i < $largo; $i++) {
		if ($campo[$i] != ' ') {
			$ok=0;
		}
	}
	if ($ok == 0) {
		return 0;
	} else {
		return 1;
	}
}

function verificaFecha($fecha) {
	//que no haya blancos...
	for ($i=0; $i < strlen($fecha); $i++) {
		if ($fecha[$i] == ' ') {
			return 1;
		} 
	}
	$ano=substr($fecha,0,4);
	$mes=substr($fecha,4,2);
	$dia=substr($fecha,6,2);
	$fecha_actual = date("Ymd");
	$fecha_limite = date("19000101");
	if (checkdate($mes,$dia,$ano)) {
		if ($fecha < $fecha_limite || $fecha > $fecha_actual ) {
			return 1;
		} else {
			return 0;
		}
	} else {
		return 1;
	}
}

function verificaLargoBlancos($campo,$long,$numCamp,$numReg) {
	$longCampo=strlen($campo);
	if ($longCampo != $long) {
		print ("Error en el largo del campo numero $num en el regsitro numero: $numReg<br/>\n");
		return $numCamp;
	}
	if (verficaBlancos($campo)) {
		print ("Error campo numero $num esta en blanco en el registro numero: $numReg<br/>\n");
		return $numCamp;
	}
} // no esta en uso... para ver si se pone mas adenate... si conviene...

function verificarCampos($nombreArc,$registro,$mysqli,$numReg) {
	//print("VERIFICACION REGSITRO ".$numReg."<br><br>");
	$cantCampos=11;
	$campoLargo=161;
	$cuitArc=substr($nombreArc,4,11);
	//print("CUIT ARC= $cuitArc<br/>\n");
	
	$campos=explode("|", $registro);
	
	//verifico el largo del campo...
	$largo=strlen($registro);
	//print("LONGITUD REG= $largo<br/>\n");
	if ($largo != $campoLargo) {
		//print("Error en el largo del registro numero: $numReg<br/>\n");
		return array(-1,"Error longitud del registro");
	}
	//verifico la cant de campos....
	$cant = count($campos);
	//print("CANT CAMPOS REG= $cant<br/>\n");
	if ($cant != $cantCampos) {
		//print("Error cantidad de campos del registro numero: $numReg<br/>\n");
		return array(-2,"Error cantidad de campos");
	}
	
	//verifico que el cuit del registro sea igual al nombre del archivo
	$cuitReg=$campos[0];
	//print("CUIT REG= $cuitReg<br/>\n");
	if (strcmp($cuitReg,$cuitArc)!=0) {
		//print("Error nrcuit del registro numero: $numReg <br/>\n");
		return array(1,"Error CUIT en el registro");
	}
	
	//verifico que el cuil exista ya que si no no hay titular emparentado con el...
	$cuilReg=$campos[1];
	if (strlen($cuilReg)==11) {
		$sql = "select * from empleados where nrcuit = $cuitReg and nrcuil = $cuilReg ";
		//print($sql."<br>");
		if ($sentencia = $mysqli->prepare($sql)) {
			$sentencia->execute();
			$sentencia->store_result();
			$cant = $sentencia->num_rows;
			if ($cant == 0) {
				//print ("Error cuil del registro numero: $numReg <br/>\n");
				return array(2,"Error CUIL en el registro");
			}
		}
	} else {
		//print ("Error cuil del registro numero: $numReg <br/>\n");
		return array(2,"Error CUIL en el registro");
	}
	
	//verifico nombre y apellido
	$apeReg=$campos[2];
	$apeLong=strlen($apeReg);
	$nomReg=$campos[3];
	$nomLong=strlen($nomReg);
	if ($apeLong!=50) {
		//print ("Error en el Apellido del registro numero: $numReg <br/>\n");
		return array(3,"Error APELLIDO en el registro");
	} 
	if (verificaBlancos($apeReg,$apeLong) == 1) {
		//print ("Error Apellido En blanco del registro numero: $numReg <br/>\n");
		return array(3,"Error APELLIDO en el registro");
	} 
	if ($nomLong!=50) { 
		//print ("Error en el Nombre del registro numero: $numReg <br/>\n");
		return array(4,"Error NOMBRE en el registro");
	} 
	if (verificaBlancos($nomReg,$apeLong)) {
		//print ("Error Nombre En blanco registro numero: $numReg <br/>\n");
		return array(4,"Error NOMBRE en el registro");
	}
	
	//verifico en parentesco.....
	$codParReg=$campos[4];
	if ($codParReg < 1 || $codParReg > 4) {
		return array(18,"Error Código Parentesco");
	}
	
	
	//verifico M o F...
	if ($campos[5] != "F" && $campos[5] != "M") {
		//print ("Error en el sexo del registro numero: $numReg <br/>\n");
		return array(8,"Error SEXO en el registro");
	}
	
	//verifico fecha de nacimiento...
	$fecNacReg=$campos[6];
	//print ("Fecha de nacimiento= $fecNacReg<br/>\n");
	if (verificaFecha($fecNacReg) != 0) {
		//print ("Error en la fecha de naciemiento del registro numero: $numReg <br/>\n");
		return array(9,"Error FECHA DE NACIMIENTO en el registro");
	}
	
	//verifico la fecha de ingreso...
	$fecIniReg=$campos[7];
	//print("fecha ingreso: $fecIniReg<br/>\n");
	if (strlen($fecIniReg) != 8) {
		//print ("Error en el formato de la fecha de inicio del registro numero: $numReg <br/>\n");
		return array(5,"Error FECHA DE INGRESO en el registro");
	} 
	if (verificaFecha($fecIniReg) != 0) {
		//print ("Error en la fecha de inicio del registro numero: $numReg <br/>\n");
		return array(5,"Error FECHA DE INGRESO en el registro");
	}

	//verifico tipo y numero de documento...
	$tipDocReg=$campos[8];
	if ($tipDocReg < 1 || $tipDocReg > 4 || strlen($tipDocReg)!= 1 || !is_numeric($tipDocReg)) {
		//print ("Error en el tipo de documento del registro numero: $numReg <br/>\n");
		return array(6,"Error TIPO DE DOCUMENTO en el registro");
	}
	$docReg=$campos[9];
	if (strlen($docReg)!=9 || !is_numeric($docReg)) {
		//print ("Error en el numero de docuemnto del regsitro numero: $numReg <br/>\n");
		return array(7,"Error NÚMERO DE DOCUMENTO en el registro");
	}
	
	//verifico si esta activo el beneficiario S/N...
	if ($campos[10] != "S" && $campos[10] != "N") {
		//print ("Error en activo del registro numero: $numReg <br/>\n");
		return array(17,"Error ACTIVO en el registro");
	}
	
	return 0;
}

//*************************************************************//
//aca empiezo con todas las llamadas a todos los controles ****//
//*************************************************************//
$nomArcOK=controlarNombreArc($archivo_name,$archivo_type,$mysqli);
//print("CONTROL NOMBRE=$nomArcOK<br/><br/>");

$contRegMalos = 0;
if ($nomArcOK==0) {
	$ncuit=substr($archivo_name,4,11);
	$destino="modulog/archivos/$ncuit/$archivo_name";
	copy($archivo['tmp_name'],$destino);
	//$archivoHost="modulog/archivos/$ncuit/$archivo_name";
	$registros = file($destino, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	
	//empiezo a leer los registros....
	for($i = 0; $i < count($registros); $i++) {
		//print ("$registros[$i] <br/>\n");
		//verifico los campos...
		$res=verificarCampos($archivo_name,$registros[$i],$mysqli,$i+1);
		//print("Resultado de verificaion: $res<br/><br/>");
		if ($res!=0) {
			$contRegMalos++;
			$regisError = $i + 1;
			$errores[$i] = array("registro" => $regisError, "coderror" => $res[0], "descrierror" => $res[1]);
		}
	}
} else {
	$errores[$i] = array("registro" => "-", "coderror" => $nomArcOK[0], "descrierror" => $nomArcOK[1]);
}

//var_dump($arrayErrores);
//var_dump($errores);

// Cargo la plantilla
$twig->display('resultadoSubidaFam.html',array("userName" => $_SESSION['userNombre'], "errores" => $errores, "regtotales" => count($registros), "regmalos" => $contRegMalos));

?>