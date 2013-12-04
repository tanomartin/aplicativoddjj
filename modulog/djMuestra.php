<?php session_save_path("../sesiones");
session_start();
if($_SESSION['nrcuit'] == null)
	header ("Location: ../caducaSes.php");

$nombreArc = $_GET['nombreArc'];
?>

<html>
<head>
<title>.: U.S.I.M.R.A. :.</title>
<META HTTP-EQUIV="Expires" CONTENT="Tue, 01 Jan 1980 1:00:00 GMT">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
</head>
<body bgcolor="#E4C192" link="#000000">
<p align="center"><img border="0" src="top.jpg" width="700" height="120"></p>
<p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
<p> 

<?php
	include ("conexion.php");
	//Ejecucion de la sentencia SQL
	$nrcuit=$_SESSION['nrcuit'];
	$sql = "select * from empleados where nrcuit = '$nrcuit'";
	$result = mysql_query($sql,$db);
	$reg = mysql_num_rows($result);
	if ($reg  < 1) {
		print ("Cantidad de empleados Registrados: 0");
	} else {
		print ("Cantidad de empleados Registrados: ".$reg);
	}

	print ("<br>");

	$sql = "select * from empleados where nrcuit = '$nrcuit' and activo = 'SI'";
	$result = mysql_query($sql,$db);
	$activos = mysql_num_rows($result);
	if ($activos < 1) {
		print ("Cantidad de empleados Activos: 0");
	} else {
		print ("Cantidad de empleados Activos: ".$activos);
	}

	$perReg=substr($nombreArc,15,2);
	$anoReg=substr($nombreArc,17,4);

	$destino="archivos/$nrcuit/$nombreArc";
	//$archivoHost="archivos/$nrcuit/$nombreArc";
	$registros = file($destino, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	$nfilas = count($registros);
	
	print ("<br>");
	
	print ("Cantidad de empleados Importados: ".$nfilas);
	
?>

<table width="100%" border="1" bordercolor="#FFFFFF" bgcolor="#CC9933">
  <tr> 
    <td><div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">VERIFIQUE QUE SE ENCUENTREN EN EL LISTADO TODOS LOS EMPLEADOS QUE INTEGRAN ESTA DDJJ.</font></strong></div></td>
  </tr>
</table>

<form name="form1" method="post" action="ddjj.php?filas=<?php echo $nfilas?>&nrcuit=<?php echo $nrcuit?>">

  	<strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font size="2">Periodo 
	<?php //paso el nombre del archivo para el back
	print("<input type=hidden name=archivo value=".$nombreArc.">");
	print(" $perReg");
	print("<input type=hidden name=permes value=".$perReg.">")?> </font></font></strong>
	<p>
  	<font size="2"  face="Verdana, Arial, Helvetica, sans-serif"><strong>Año 
	<?php print(" $anoReg");
	print("<input type=hidden name=perano value=".$anoReg.">")
	
	?></strong></font>
	<p>
  
	<table border=1 width=100% bordercolorlight=#D08C35 bordercolordark=#D08C35 bordercolor=#CD8C34 cellpadding=2 cellspacing=0>
   		<td width=15%><strong><font face=Verdana, Arial, Helvetica, sans-serif size=1>CUIL</font></strong></td>
   		<td width=40%><strong><font face=Verdana, Arial, Helvetica, sans-serif size=1>Apellido y Nombre</font></strong></td>
   		<td width=15%><strong><font face=Verdana, Arial, Helvetica, sans-serif size=1>Fecha de Ingreso</font></strong></td>
   		<td width=30%><strong><font face=Verdana, Arial, Helvetica, sans-serif size=1>Remuneración</font></strong></td>
	</tr>
	<?php for($i = 0; $i < count($registros); $i++) {
			$campos=explode("|", $registros[$i]);
			$cuill01 = substr($campos[1],0,2);
			$cuill02 = substr($campos[1],2,8);
			$cuill03 = substr($campos[1],10,1);
			
			print ("<input type=hidden name='Z".$i."' size=20 value=".$campos[1].">");
			print ("<td width=15%><font face=Verdana size=1>".$cuill01."-".$cuill02."-".$cuill03."</font></td>");
			
			$sql = "select * from empleados where nrcuit = '$nrcuit' and activo = 'SI' and nrcuil = '$campos[1]'";
			$result = mysql_query($sql,$db);
			$row=mysql_fetch_array($result);
			print ("<input type=hidden name='X".$i."' size=20 value=\"".$row['apelli']." ".$row['nombre']."\">");
			print ("<td width=40%><font face=Verdana size=1><b>".$row['apelli']." ".$row['nombre']."</b></font></td>");
			
			$fec01 = substr($row["fecing"],0,4);
			$fec02 = substr($row["fecing"],5,2);
			$fec03 = substr($row["fecing"],8,2);
			
			print ("<input type=hidden name='Y".$i."' size=20 value=".$row["fecing"].">");			
			print ("<td width=15%><font face=Verdana size=1>".$fec03."/".$fec02."/".$fec01."</font></td>");
			
			print ("<input type=hidden name='W".$i."' size=20 value=".$campos[4].">");		
			print ("<td width=30%><font face=Verdana size=1>".(real)$campos[4]."</font></td>");
			print ("</tr>");
		}
	?>
  	</table>

  	<p>
	<strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Empleados no declarados</font></strong></p>

  	<table border=1 width=100% bordercolorlight=#D08C35 bordercolordark=#D08C35 bordercolor=#CD8C34 cellpadding=2 cellspacing=0>
   	 	<td width=15%><strong><font face=Verdana, Arial, Helvetica, sans-serif size=1>CUIL</font></strong></td>
    	<td width=40%><strong><font face=Verdana, Arial, Helvetica, sans-serif size=1>Apellido y Nombre</font></strong></td>
		<td width=15%><strong><font face=Verdana, Arial, Helvetica, sans-serif size=1>Fecha de Ingreso</font></strong></td>
    	<td width=30%><strong><font face=Verdana, Arial, Helvetica, sans-serif size=1>Motivo</font></strong></td>
    </tr>

    <?php $sql = "select * from empleados where nrcuit = '$nrcuit' and activo = 'NO'";
	$result = mysql_query($sql,$db);
	$mfilas = mysql_num_rows($result);
	if ($mfilas < 1) {
		print ("<font face=Verdana size=1>Cantidad de empleados Inactivos: 0</font>");
	} else {
		Print ("<font face=Verdana size=1>Cantidad de empleados Inactivos: ".$mfilas."</font>");
	}

	print ("<input type=hidden name=P1 size=20 value=".$mfilas.">");	  
	$i = 1;
	while ($row=mysql_fetch_array($result)) {
		print ("<tr>");
		
		print ("<input type=hidden name='A".$i."' size=20 value=".$row["nrcuil"].">");
		$cuil[$i-1] = $row["nrcuil"];
		$cuill01 = substr($row['nrcuil'],0,2);
		$cuill02 = substr($row['nrcuil'],2,8);
		$cuill03 = substr($row['nrcuil'],10,1);
		print ("<td width=15%><font face=Verdana size=1>".$cuill01."-".$cuill02."-".$cuill03."</font></td>");
		$totnom = sprintf("%s %s", $row["apelli"],$row["nombre"]);
		
		print ("<input type=hidden name='B".$i."' size=20 value=\"".$totnom."\">");
		print ("<td width=35%><font face=Verdana size=1><b>".$totnom."</b></font></td>");
		$fec01 = substr($row["fecing"],0,4);
		$fec02 = substr($row["fecing"],5,2);
		$fec03 = substr($row["fecing"],8,2);
		
		print ("<input type=hidden name='C".$i."' size=20 value=".$row["fecing"].">");
		print ("<td width=25%><font face=Verdana size=1>".$fec03."/".$fec02."/".$fec01."</font></td>");
		print ("<td width=25%><font face=Verdana size=1><input type=text name=D".$i."size=20 ></font></td>");
		print ("</tr>");
		$i++;
	}
	print ("</font></p>");
	?>

  	</table>
  	<strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
 	<input type="submit" value="Ingresar Datos" name="B1" style="background-color: #E4C192; border-style: solid; border-color: #D28E37">
	</font></strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font> 

</form>

<a href="menug.php"><font color="#CD8C34" face="Verdana" size="2"><b>Volver</b></font></a> 
</html>