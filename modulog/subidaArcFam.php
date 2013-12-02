<?php session_save_path("../sesiones");
session_start();
if($_SESSION['nrcuit'] == null)
	header ("Location: ../caducaSes.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Alta de Empleados para Empresas</title>
</head>

<?php
include ("conexion.php");

function controlarNombreArc($nombre,$type,$db) {
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
		if (strcmp($inicio,"FAM-")) {
			if (strpos($type, $ext) !== false) {
				$sql = "select * from empresa where nrcuit = $ncuit";
				$result = mysql_query($sql,$db);
				$cant = mysql_num_rows($result);
				//controlo que exista la empresa y que el cuit concuerde con la sesion
				if (($cant == 1) && ($ncuit == $_SESSION['nrcuit'])){
					return 0;
				} else {
					return 21;
				}
			} else {
				return 20;
			}
		} else {
			return 20;
		}
	} else {
		return 20;
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

function verificarCampos($nombreArc,$registro,$db,$numReg) {
	$cantCampos=11;
	$campoLargo=161;
	$cuitArc=substr($nombreArc,4,11);
	
	$campos=explode("|", $registro);
	
	//verifico el largo del campo...
	$largo=strlen($registro);
	//print("LONGITUD REG= $largo<br/>\n");
	if ($largo != $campoLargo) {
		//print("Error en el largo del registro numero: $numReg<br/>\n");
		return -1;
	}
	//verifico la cant de campos....
	$cant = count($campos);
	if ($cant != $cantCampos) {
		//print("Error cantidad de campos del registro numero: $numReg<br/>\n");
		return -2;
	}
	
	//verifico que el cuit del registro sea igual al nombre del archivo
	$cuitReg=$campos[0];
	if (strcmp($cuitReg,$cuitArc)!=0) {
		//print("Error nrcuit del registro numero: $numReg <br/>\n");
		return 1;
	}
	
	//verifico que el cuil exista ya que si no no hay titular emparentado con el...
	$cuilReg=$campos[1];
	if (strlen($cuilReg)==11) {
		$sql = "select * from empleados where nrcuit = $cuitReg and nrcuil = $cuilReg ";
		$result = mysql_query($sql,$db);
		$cant = mysql_num_rows($result);
		if ($cant != 1) {
			//print ("Error cuil del registro numero: $numReg <br/>\n");
			return 2;
		}
	} else {
		//print ("Error cuil del registro numero: $numReg <br/>\n");
		return 2;
	}
	
	//verifico nombre y apellido
	$apeReg=$campos[2];
	$apeLong=strlen($apeReg);
	$nomReg=$campos[3];
	$nomLong=strlen($nomReg);
	if ($apeLong!=50) {
		//print ("Error en el Apellido del registro numero: $numReg <br/>\n");
		return 3;
	} 
	if (verificaBlancos($apeReg,$apeLong) == 1) {
		//print ("Error Apellido En blanco del registro numero: $numReg <br/>\n");
		return 3;
	} 
	if ($nomLong!=50) { 
		//print ("Error en el Nombre del registro numero: $numReg <br/>\n");
		return 4;
	} 
	if (verificaBlancos($nomReg,$apeLong)) {
		//print ("Error Nombre En blanco registro numero: $numReg <br/>\n");
		return 4;
	}
	
	//verifico en parentesco.....
	$codParReg=$campos[4];
	if ($codParReg < 1 || $codParReg > 4) {
		return 18;
	}
	
	
	//verifico M o F...
	if ($campos[5] != "F" && $campos[5] != "M") {
		//print ("Error en el sexo del registro numero: $numReg <br/>\n");
		return 8;
	}
	
	//verifico fecha de nacimiento...
	$fecNacReg=$campos[6];
	//print ("Fecha de nacimiento= $fecNacReg<br/>\n");
	if (verificaFecha($fecNacReg) != 0) {
		//print ("Error en la fecha de naciemiento del registro numero: $numReg <br/>\n");
		return 9;
	}
	
	//verifico la fecha de ingreso...
	$fecIniReg=$campos[7];
	//print("fecha ingreso: $fecIniReg<br/>\n");
	if (strlen($fecIniReg) != 8) {
		//print ("Error en el formato de la fecha de inicio del registro numero: $numReg <br/>\n");
		return 5;
	} 
	if (verificaFecha($fecIniReg) != 0) {
		//print ("Error en la fecha de inicio del registro numero: $numReg <br/>\n");
		return 5;
	}

	//verifico tipo y numero de documento...
	$tipDocReg=$campos[8];
	if ($tipDocReg < 1 || $tipDocReg > 4 || strlen($tipDocReg)!= 1 || !is_numeric($tipDocReg)) {
		//print ("Error en el tipo de documento del registro numero: $numReg <br/>\n");
		return 6;
	}
	$docReg=$campos[9];
	if (strlen($docReg)!=9 || !is_numeric($docReg)) {
		//print ("Error en el numero de docuemnto del regsitro numero: $numReg <br/>\n");
		return 7;
	}
	
	//verifico si esta activo el beneficiario S/N...
	if ($campos[10] != "S" && $campos[10] != "N") {
		//print ("Error en activo del registro numero: $numReg <br/>\n");
		return 17;
	}
	
	return 0;
}


//*************************************************************//
//aca empiezo con todas las llamadas a todos los controles ****//
//*************************************************************//
$archivo = $_FILES['archivo'];	
$archivo_name = $archivo['name'];
$archivo_type = $archivo['type'];
$nomArcOK=controlarNombreArc($archivo_name,$archivo_type,$db);
//print("CONTROL NOMBRE=$nomArcOK<br/>\n");
$contRegMalos = 0;
if ($nomArcOK==0) {
	$ncuit=substr($archivo_name,4,11);
	$destino="archivos/$ncuit/$archivo_name";
	copy($archivo['tmp_name'],$destino);
	//$archivoHost="http://www.usimra.com.ar/ddjj/modulog/archivos/$ncuit/$archivo_name";
	$registros = file($destino, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	
	//empiezo a leer los registros....
	for($i = 0; $i < count($registros); $i++) {
		//print ("$registros[$i] <br/>\n");
		//verifico los campos...
		$res=verificarCampos($archivo_name,$registros[$i],$db,$i+1);
		//print("Resultado de verificaion: $res<br/>\n<br/>\n");
		$arrayErrores[$i]=$res;
		if ($res!=0) {
			$contRegMalos++;
		}
	}
} else {
	$arrayErrores[0]=$nomArcOK;
}
?>


<body bgcolor="#E4C192">
<p align="center"><img border="0" src="top.jpg" width="700" height="120" /></p>
<table width="700" height="184" border="1" align="center">
  <tr align="center" valign="top">
    <td height="23" colspan="2"><div align="center"><em><strong><font face="Arial, Helvetica, sans-serif">Resultado de control de registros de Familiares </font></strong></em></div></td>
  </tr>
  <tr align="center" valign="top">
    <td width="160" height="23"><div align="left"><strong>Cantidad de Registros: </strong></div></td>
    <td width="524"><div align="left"><?php print(count($registros)); ?></div></td>
  </tr>
  <tr align="center" valign="top">
    <td height="23"><div align="left"><strong>Registros Erroneos </strong></div></td>
    <td><div align="left"><?php print($contRegMalos); ?></div></td>
  </tr>
  <tr align="center" valign="top">
    <td height="23"><div align="left"><strong>Listado de Errores </strong></div></td>
    <td>
      <div align="left">
     <?php 
	 	$hayErrores=0;
		for($i = 0; $i < count($arrayErrores); $i++) {
			if ($arrayErrores[$i] > 19) {
				print("Error en nombre de archivo -- Error Número: $arrayErrores[$i].<br/>\n");
				$hayErrores=1;
			}
			if (($arrayErrores[$i] < 19) && ($arrayErrores[$i]!=0))  {
				$numReg=$i+1;
				print("Registro Número: $numReg -- Error Número: $arrayErrores[$i].<br/>\n");
				$hayErrores=1;
			}
		} 
		if ($hayErrores == 0) {
			print("No se ha encontrado ningun error en los registros.");
		}
	?>
      </div></td>
  </tr>
  <tr align="center" valign="top">
    <td height="27" colspan="2">
	<?php 
		if (($contRegMalos!=0) || ($nomArcOK!=0)) {
			print ("<a href=menug.php>".VOLVER);
		}
		else {
			print ("<a href=importarFam.php?nombreArc=".$archivo_name.">".IMPORTAR);
			print ("<br/>\n <br/>\n");
			print ("<a href=menug.php>".VOLVER);
		}
	?>	</td>
  </tr>
  <tr align="center" valign="top">
    <td height="27" colspan="2">&nbsp;</td>
  </tr>
  <tr align="center" valign="top">
    <td height="20" colspan="2" bgcolor="#CF8B34"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Copyright 
    2007 <strong>U.S.I.M.R.A.</strong> - Todos los derechos reservados</font></div></td>
  </tr>
</table>
</form>
</body>
</html>