<?php session_save_path("../sesiones");
session_start();
if($_SESSION['nrcuit'] == null)
	header ("Location: ../caducaSes.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Importando Registros.</title>
</head>
<?php
	include ("conexion.php");
	
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
	
	$cuit=$_SESSION['nrcuit'];
	//$archivoHost="http://www.usimra.com.ar/ddjj/modulog/archivos/$cuit/$nombreArc";
	$archivo_name = $_GET['nombreArc'];
	$destino="archivos/$cuit/$archivo_name";
	$registros = file($destino, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
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
		
		$sql = "INSERT INTO empleados VALUES ('".trim($campos[0])."','".trim($campos[1])."','".trim($campos[2])."','".trim($campos[3])."','".trim($campos[4])."','".trim($campos[5])."','".trim($campos[6])."','".trim($campos[7])."','".trim($campos[8])."','".trim($campos[9])."','".trim($campos[10])."','".trim($campos[11])."','".trim($campos[12])."','".trim($campos[13])."','".trim($campos[14])."','".trim($campos[15])."','".trim($campos[16])."',DEFAULT)";

		$result = mysql_query($sql,$db);
		//print ("$sql<br/>\n");	
	}	
?>
<body bgcolor="#E4C192">
<p align="center"><img border="0" src="top.jpg" width="700" height="120" /></p>
<table width="700" border="1" align="center">
  <tr>
    <td width="690"><div align="center"><font face="Arial, Helvetica, sans-serif"><strong><em>Se ha realizado la importacion con exito. </em></strong></font></div></td>
  </tr>
  <tr>
    <td><div align="center">
      <?php
		print ("<a href=menug.php>".VOLVER);
	?>
    </div></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#E4C192">&nbsp;</td>
  </tr>
     <td width="690" colspan="2" bgcolor="#CF8B34"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Copyright 
    2007 <strong>U.S.I.M.R.A.</strong> - Todos los derechos reservados</font></div></td>
          </tr>
</table>
</body>
</html>
