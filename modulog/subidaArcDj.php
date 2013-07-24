<? session_save_path("../sesiones");
session_start();
if($_SESSION['nrcuit'] == null)
	header ("Location: ../caducaSes.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Resultado DDJJ</title>
</head>

<?
include ("conexion.php");

function controlarNombreArc($nombre,$type,$db) {
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
			if (ereg($ext,$type)) {
				$sql = "select * from empresa where nrcuit = $ncuit";
				$result = mysql_db_query("uv0472_aplicativo",$sql,$db);
				$cant = mysql_num_rows($result);
				//controlo que exista la empresa y que el cuit concuerde con la sesion
				if (($cant == 1) && ($ncuit == $_SESSION['nrcuit'])){
					$mes=substr($nombre,15,2);
					$anio=substr($nombre,17,4);
					//print("$mes ---- $anio ---- ");
					if ($mes < 1 || !is_numeric($mes) || !is_numeric($anio) || $anio < 2000 || $anio > date("Y")) {
						return 22;
					} else {
						return 0;
					}
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

function verificaRemun($campo,$long) {
	$longCampo=strlen($campo);
	if ($longCampo != $long) {
		return 192;
	}
	if (!is_numeric($campo)) {
		return 193;
	}
	//print("Es un punto $campo[7] --- ");
	if ($campo[7] != '.') {
		return 194;
	}
	return 0;
} 

function verificarCampos($nombreArc,$registro,$db) {
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
	//print("$cuitReg ----");
	if (strcmp($cuitReg,$cuitArc)!=0) {
		//print("Error nrcuit del registro numero: $numReg <br/>\n");
		return 1;
	}
	
	//verifico que el cuil exista ya que si no no hay titular emparentado con el...
	$cuilReg=$campos[1];
	if (strlen($cuilReg)==11) {
		$sql = "select * from empleados where nrcuit = $cuitReg and nrcuil = $cuilReg";
		$result = mysql_db_query("uv0472_aplicativo",$sql,$db);
		$cant = mysql_num_rows($result);
		if ($cant != 1) {
			//print ("Error cuil del registro numero: $numReg <br/>\n");
			return 2;
		} else {
			$row=mysql_fetch_array($result);
			if ($row['activo'] != 'SI') {
				return 192;
			}
		}
	} else {
		//print ("Error cuil del registro numero: $numReg <br/>\n");
		return 2;
	}
	
	//verifico mes y anio del registro.... solo que sean validos...
	$mesReg=$campos[2];
	$anoReg=$campos[3];
	
	$sqlMesAnio = "select * from periodos where anio = $anoReg and mes = $mesReg";
	$resMesAnio = mysql_db_query("uv0472_aplicativo",$sqlMesAnio,$db);
	$canMNesAnio = mysql_num_rows($resMesAnio);
	if ($canMNesAnio != 1) {
		$errMes = 1;
	} else {
		$errMes = 0;
	}
	
	if ($errMes == 1 || !is_numeric($mesReg) || $mesReg != $mesArc) {
		return 190;
	}
	if (!is_numeric($anoReg) || $anoReg < 2000 || $anoReg != $anoArc) {
		return 191;
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
$nomArcOK=controlarNombreArc($archivo_name,$archivo_type,$db);
//print("CONTROL NOMBRE=$nomArcOK<br/>\n");
$contRegMalos = 0;
if ($nomArcOK==0) {
	$ncuit=substr($archivo_name,3,11);
	$destino="archivos/$ncuit/$archivo_name";
	copy($archivo,$destino);
	
	$archivoHost="archivos/$ncuit/$archivo_name";
	$registros = file($archivoHost, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	
	//empiezo a leer los registros....
	for($i = 0; $i < count($registros); $i++) {
		//print ("$registros[$i] <br/>\n");
		//verifico los campos...
		$res=verificarCampos($archivo_name,$registros[$i],$db);
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
    <td height="23" colspan="2"><div align="center"><em><strong><font face="Arial, Helvetica, sans-serif">Resultado de control de registros de D.D.J.J. </font></strong></em></div></td>
  </tr>
  <tr align="center" valign="top">
    <td width="160" height="23"><div align="left"><strong>Cantidad de Registros: </strong></div></td>
    <td width="524"><div align="left"><? print(count($registros)); ?></div></td>
  </tr>
  <tr align="center" valign="top">
    <td height="23"><div align="left"><strong>Registros Erroneos </strong></div></td>
    <td><div align="left"><? print($contRegMalos); ?></div></td>
  </tr>
  <tr align="center" valign="top">
    <td height="23"><div align="left"><strong>Listado de Errores </strong></div></td>
    <td>
      <div align="left">
     <? 
	 	$hayErrores=0;
		for($i = 0; $i < count($arrayErrores); $i++) {
			if (($arrayErrores[$i] > 19) && ($arrayErrores[$i] < 30)){
				print("Error en nombre de archivo -- Error Número: $arrayErrores[$i].<br/>\n");
				$hayErrores=1;
			}
			if (( ($arrayErrores[$i] <= 19) || ($arrayErrores[$i] > 30) ) && ($arrayErrores[$i]!=0))  {
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
	<? 
		if (($contRegMalos!=0) || ($nomArcOK!=0)) {
			print ("<a href=menug.php>".VOLVER);
		}
		else {
			print ("<a href=djMuestra.php?nombreArc=".$archivo_name.">".CONTINUAR);
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
</body>
</html>