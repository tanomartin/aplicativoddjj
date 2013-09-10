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

function controlarNombreArc($nombre,$type,$mysqli) {
	//print("MODULO CONTROL NOMBRE<br/>\n");
	$ext="text";
	$long=strlen($nombre);
	//print("TIPO= $type<br/>\n");
	//print ("LONGITUD: $long <br/>\n");
	if (strlen($nombre) == 19) {
		$inicio=substr($nombre,0,4);
		//print ("INICIO: $inicio <br/>\n");
		$ncuit=substr($nombre,4,11);
		//print ("CUIT: $ncuit <br/>\n");
		if (strcmp($inicio,"EMP-")) {
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
					return array(20,"Error nombre de archivo");
				}
			} else {
				return array(20,"Error nombre de archivo");
			}
		} else {
			return array(20,"Error nombre de archivo");
		}
	} else {
		return array(20,"Error nombre de archivo");
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
		//print ("Error en el largo del campo numero $num en el regsitro numero: $numReg<br/>\n");
		return $numCamp;
	}
	if (verficaBlancos($campo)) {
		//print ("Error campo numero $num esta en blanco en el registro numero: $numReg<br/>\n");
		return $numCamp;
	}
} // no esta en uso... para ver si se pone mas adenate... si conviene...

function verificarCampos($nombreArc,$registro,$mysqli,$numReg) {
	$cantCampos=17;
	$campoLargo=307;
	$cuitArc=substr($nombreArc,4,11);
	
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
	if ($cant != $cantCampos) {
		//print("Error cantidad de campos del registro numero: $numReg<br/>\n");
		return array(-2,"Error cantidad de campos");
	}
	
	//verifico que el cuit del registro sea igual al nombre del archivo0
	$cuitReg=$campos[0];
	if (strcmp($cuitReg,$cuitArc)!=0) {
		//print("Error nrcuit del registro numero: $numReg <br/>\n");
		return array(1,"Error CUIT en el registro");
	}
	
	//verifico el cuil y q no exista....
	$cuilReg=$campos[1];
	if (strlen($cuilReg)==11) {
		$sql = "select * from empleados where nrcuit = $cuitReg and nrcuil = $cuilReg ";
		//print($sql."<br>");
		if ($sentencia = $mysqli->prepare($sql)) {
			$sentencia->execute();
			$sentencia->store_result();
			$cant = $sentencia->num_rows;
			if ($cant != 0) {
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
	
	//verifico la fecha de ingreso...
	$fecIniReg=$campos[4];
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
	$tipDocReg=$campos[5];
	if ($tipDocReg < 1 || $tipDocReg > 4 || strlen($tipDocReg)!= 1 || !is_numeric($tipDocReg)) {
		//print ("Error en el tipo de documento del registro numero: $numReg <br/>\n");
		return array(6,"Error TIPO DE DOCUMENTO en el registro");
	}
	$docReg=$campos[6];
	if (strlen($docReg)!=9 || !is_numeric($docReg)) {
		//print ("Error en el numero de docuemnto del regsitro numero: $numReg <br/>\n");
		return array(7,"Error NUMERO DE DOCUMENTO en el registro");
	}
	
	//verifico M o F...
	if ($campos[7] != "F" && $campos[7] != "M") {
		//print ("Error en el sexo del registro numero: $numReg <br/>\n");
		return array(8,"Error SEXO en el registro");
	}
	
	//verifico fecha de nacimiento...
	$fecNacReg=$campos[8];
	//print ("Fecha de nacimiento= $fecNacReg<br/>\n");
	if (verificaFecha($fecNacReg) != 0) {
		//print ("Error en la fecha de naciemiento del registro numero: $numReg <br/>\n");
		return array(9,"Error FECHA DE NACIMIENTO en el registro");
	}
	
	
	//verifico estaod civil...
	if ( strlen($campos[9]) != 1 || $campos[9] < 1 || $campos[9] > 5 || !is_numeric($campos[9]) ) {
		//print("Error en el estado civil del registro numero: $numReg<br/>\n");
		return array(10,"Error ESTADO CIVIL en el registro");
	}
	
	//verifico direc locale y copole..
	$direLong=strlen($campos[10]);
	if ($direLong != 50) {
		//print ("Error en la direccion en el registro numero: $numReg<br/>\n");
		return array(11,"Error DIRECCION en el registro");
	}
	if (verificaBlancos($campos[10],$direLong)) {
		//print ("Error direccion en blanco en el registro numero: $numReg<br/>\n ");
		return array(11,"Error DIRECCION en el registro");
	}
	$locaLong=strlen($campos[11]);
	if ($locaLong != 50) {
		//print ("Error en la localidad en el registro numero: $numReg<br/>\n");
		return array(12,"Error LOCALIDAD en el registro");
	}
	if (verificaBlancos($campos[11],$locaLong)) {
		//print ("Error localidad en blanco en el registro numero: $numReg<br/>\n ");
		return array(12,"Error LOCALIDAD en el registro");
	}
	$cpLong=strlen($campos[12]);
	if ($cpLong != 12) {
		//print ("Error en el codigo postal en el registro numero: $numReg<br/>\n");
		return array(13,"Error CODIGO POSTAL en el registro");
	}
	if (verificaBlancos($campos[12],$cpLong)) {
		//print ("Error codigo postal en blanco en el registro numero: $numReg<br/>\n ");
		return array(13,"Error CODIGO POSTAL en el registro");
	}
	
	//verifco provincia...
	$provReg=$campos[13];
	$longProv=strlen($provReg);
	if ($longProv != 2 || !is_numeric($provReg)) {
		//print ("Error en el codigo de provincia del registro numero: $numReg<br/>\n");
		return array(14,"Error PROVINCIA en el registro");
	}
	if ($provReg < 1 || $provReg > 24) {
		//print ("Erro codigo de provincia fuera de rango en el registro numero: $numReg<br/>\n");
		return array(14,"Error PROVINCIA en el registro");
	}
	
	//verifico nacionalidad...
	$longNac=strlen($campos[14]);
	if ($longNac!=20) {
		//print ("Error en la nacionalidad del regsitro numero: $numReg<br/>\n");
		return array(15,"Error NACIONALIDAD en el registro");
	}
	if (verificaBlancos($campos[14],$longNac)) {
		//print ("Error nacionalidad en blanco registro numero: $numReg<br/>\n");
		return array(15,"Error NACIONALIDAD en el registro");
	}
	
	//verifico categoria con tablas...
	if (strlen($campos[15]) != 6) {
		//print ("Error en el codigo rama categoria en el registro numero: $numReg<br/>\n");
		return array(16,"Error RAMA/CATEGORIA en el registro");
	}
	$ramaReg=substr($campos[15],0,3);
	$cateReg=substr($campos[15],3,3);
	
	//control rama y categoria
	$sql = "select * from empresa where nrcuit = $cuitReg";
	$respuesta = $mysqli -> query($sql);
	$empresaData = $respuesta -> fetch_assoc();
	if ($empresaData['rramaa']!=$ramaReg ) {
		//print ("Error la rama no corresponde con la rama cargada en la empresa en el registro numero: $numReg<br/>\n");
		return array(16,"Error RAMA/CATEGORIA en el registro");
	}
	$sql = "select * from categorias where codram = $ramaReg and codcat = $cateReg";
	//print($sql."<br>");
	$respuesta = $mysqli -> query($sql);
	$cant = $respuesta -> num_rows;
	if ($cant != 1) {
		//print ("Error la categoria no existe en la rama elegida en el registro numero: $numReg<br/>\n");
		return array(16,"Error RAMA/CATEGORIA en el registro");
	}
	
	//verifico si esta activo S/N...
	if ($campos[16] != "S" && $campos[16] != "N") {
		//print ("Error en activo del registro numero: $numReg <br/>\n");
		return array(17,"Error ACTIVO en el registro");
	}
	
	return 0;
}


//*************************************************************//
//aca empiezo con todas las llamadas a todos los controles ****//
//*************************************************************//
$nomArcOK=controlarNombreArc($archivo_name,$archivo_type,$mysqli);
//print("CONTROL NOMBRE=$nomArcOK<br/>\n");
$contRegMalos = 0;
if ($nomArcOK==0) {
	$ncuit=substr($archivo_name,4,11);
	$carp="archivos/$ncuit";
	$destino="modulog/archivos/$ncuit/$archivo_name";
	copy($archivo['tmp_name'],$destino);
	//$archivoHost="modulog/archivos/$ncuit/$archivo_name";
	$registros = file($destino, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	
	//empiezo a leer los registros....
	for($i = 0; $i < count($registros); $i++) {
		//print ("$registros[$i] <br/>\n");
		//verifico los campos...
		$res=verificarCampos($archivo_name,$registros[$i],$mysqli,$i+1);
		//print("Resultado de verificaion: $res<br/>\n<br/>\n");
		if ($res!=0) {
			$regisError = $i + 1;
			$errores[$contRegMalos] = array("registro" => $regisError, "coderror" => $res[0], "descrierror" => $res[1]);
			$contRegMalos++;
		}
	}
} else {
	$errores[0] = array("registro" => "-", "coderror" => $nomArcOK[0], "descrierror" => $nomArcOK[1]);
}

//var_dump($errores);

$twig->display('resultadoSubidaEmp.html',array("userName" => $_SESSION['userNombre'], "errores" => $errores, "regtotales" => count($registros), "regmalos" => $contRegMalos));


?>