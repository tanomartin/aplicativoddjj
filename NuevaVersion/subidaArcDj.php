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
	if (strlen($nombre) == 25) {
		$inicio=substr($nombre,0,2);
		//print ("INICIO: $inicio <br/>\n");
		$ncuit=substr($nombre,3,11);
		//print ("CUIT: $ncuit <br/>\n");
		if (strcmp($inicio,"DJ-")) {
			if (strpos($type, $ext) !== false) {
				$sql = "select * from empresa where nrcuit = $ncuit";
				//print($sql."<br>");
				if ($sentencia = $mysqli->prepare($sql)) {
					$sentencia->execute();
					$sentencia->store_result();
					$cant = $sentencia->num_rows;
					//controlo que exista la empresa y que el cuit concuerde con la sesion
					if (($cant == 1) && ($ncuit == $_SESSION['userCuit'])){
						$mes=substr($nombre,15,2);
						$anio=substr($nombre,17,4);
						//print("$mes ---- $anio ---- <br>");
						if ($mes < 1 || !is_numeric($mes) || !is_numeric($anio) || $anio < 2000 || $anio > date("Y")) {
							return array(22,"Error Fecha invalida nombre de archivo Dj");
						} else {
							return 0;
						}
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

function verificaRemun($campo,$long) {
	$longCampo=strlen($campo);
	if ($longCampo != $long) {
		return array(195,"Error en la cantidad dígitos en la remuneración");
	}
	if (!is_numeric($campo)) {
		return array(193,"Error Remuneración no numérica");
	}
	//print("Es un punto $campo[7] --- ");
	if ($campo[7] != '.') {
		return array(194,"Error Remuneración sin separación decimal");
	}
	return 0;
} 

function verificarCampos($nombreArc,$registro,$mysqli) {
	$cantCampos=5;
	$campoLargo=42;
	$cuitArc=substr($nombreArc,3,11);
	$anoArc=substr($nombreArc,17,4);
	$mesArc=substr($nombreArc,15,2);
	//print("$cuitArc -- archivo---");
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
	
	//verifico que el cuit del registro sea igual al nombre del archivo
	$cuitReg=$campos[0];
	//print("$cuitReg ----");
	if (strcmp($cuitReg,$cuitArc)!=0) {
		//print("Error nrcuit del registro numero: $numReg <br/>\n");
		return array(1,"Error CUIT en el registro");
	}
	
	//verifico que el cuil exista ya que si no no hay titular emparentado con el...
	$cuilReg=$campos[1];
	if (strlen($cuilReg)==11) {
		$sql = "select * from empleados where nrcuit = $cuitReg and nrcuil = $cuilReg";
		//print($sql."<br>");
		$respuesta = $mysqli -> query($sql);
		$cant = $respuesta -> num_rows;
		if ($cant != 1) {
			//print ("Error cuil del registro numero: $numReg <br/>\n");
			return array(2,"Error CUIL en el registro");
		} else {
			$row = $respuesta -> fetch_assoc();
			//print($row['activo']."<br>");
			if ($row['activo'] != 'SI') {
				return array(192,"Error Intentando declarar un empleado inactivo");
			}
		}
	} else {
		//print ("Error cuil del registro numero: $numReg <br/>\n");
		return array(2,"Error CUIL en el registro");
	}
	
	//verifico mes y anio del registro.... solo que sean validos...
	$mesReg=$campos[2];
	$anoReg=$campos[3];
	
	$sqlMesAnio = "select * from periodos where anio = $anoReg and mes = $mesReg";
	//print($sqlMesAnio."<br>");
	$respuesta = $mysqli -> query($sql);
	$canMNesAnio = $respuesta -> num_rows;
	if ($canMNesAnio != 1) {
		$errMes = 1;
	} else {
		$errMes = 0;
	}
	
	if ($errMes == 1 || !is_numeric($mesReg) || $mesReg != $mesArc) {
		return array(190,"Error Mes del registro");
	}
	if (!is_numeric($anoReg) || $anoReg < 2000 || $anoReg != $anoArc) {
		return array(191,"Error Año del registro");
	}	
	
	$remuReg=$campos[4];
	$remuLong=10;
	$remuVer=verificaRemun($remuReg,$remuLong);
	if ($remuVer!=0) {
		return $remuVer;
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
	$ncuit=substr($archivo_name,3,11);
	$destino="modulog/archivos/$ncuit/$archivo_name";
	copy($archivo['tmp_name'],$destino);
	
	//$archivoHost="archivos/$ncuit/$archivo_name";
	$registros = file($destino, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	
	//empiezo a leer los registros....
	for($i = 0; $i < count($registros); $i++) {
		//print ("$registros[$i] <br/>\n");
		//verifico los campos...
		$res=verificarCampos($archivo_name,$registros[$i],$mysqli);
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

$twig->display('resultadoSubidaDj.html',array("userName" => $_SESSION['userNombre'], "errores" => $errores, "regtotales" => count($registros), "regmalos" => $contRegMalos, "nombreArchivo" => $archivo_name));

?>