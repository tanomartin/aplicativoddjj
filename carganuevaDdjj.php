<?php session_save_path("sesiones");
session_start();
if($_SESSION['nrcuit'] == null)
	header ("Location: caducaSes.php");
include("lib/conexion.php");
?>

<html>
<head>
<title>.: U.S.I.M.R.A. :.</title>

<script>
function valida_envia(){ 
 	//valido el anio 
    if (document.getElementById('anio').value == -1){ 
       alert("Tiene que ingresar el año correctamente");
       document.form1.anio.focus();
       return false; 
    } 
    //valido el mes 
    if (document.getElementById('periodos').value == -1){ 
       alert("Tiene que ingresar el mes correctamente");
       document.form1.periodos.focus();
       return false; 
    } 
} 

function ComponerLista(anio) {
		document.forms.form1.anio.disabled = true;
		document.forms.form1.periodos.length = 0;
		cargarPeriodos(anio);
}

function cargarPeriodos(anio) {
	var o
	document.forms.form1.periodos.disabled=true;
	o = document.createElement("OPTION");
	o.text = '----';
	o.value = -1;
	document.forms.form1.periodos.options.add(o);
	<?php	
		$sql3 = "select * from periodos order by mes ASC";
		$result3 = mysql_query($sql3,$db);
		while ($row3 = mysql_fetch_array($result3)) { ?>
			if (anio == <?php echo $row3["anio"]; ?>) {
					o = document.createElement("OPTION");
					o.text = '<?php echo $row3["descripcion"]; ?>';
					o.value = <?php echo $row3["mes"]; ?>;
					document.forms.form1.periodos.options.add(o);
			} 
	<?php
		}
	?> 
	document.forms.form1.periodos.disabled=false;
	document.forms.form1.anio.disabled=false;
}

function CargarMonto(periodo, total) {
	var veri = 0;
	<?php 
		$sql = "select * from extraordinarios";
		$result = mysql_query($sql,$db);
		while ($row = mysql_fetch_array($result)) { ?>
			if (document.getElementById('anio').value == <?php echo $row["anio"]; ?> && periodo == <?php echo $row["mes"]; ?> && <?php echo $row["tipo"]; ?> == 0) {
				for (i=1; i<=total; i++) {
					document.getElementById('T'+i).value =  <?php echo $row["valor"]; ?>;
					document.getElementById('T'+i).setAttribute('readOnly','readonly');
				}
				veri = 1;
			}
  <?php } ?>
  	if (veri == 0) {
		for (i=1; i<=total; i++) {
			document.getElementById('T'+i).value =  "0.00";
			document.getElementById('T'+i).removeAttribute('readOnly'); 
		}
	}
  		
}
</script>

<META HTTP-EQUIV="Expires" CONTENT="Tue, 01 Jan 1980 1:00:00 GMT">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
</head>
<body bgcolor="#E4C192" link="#000000">
  <p align="center"><img border="0" src="img/top.jpg" width="700" height="120"></p>
  <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"></p>
<?php
$sql = "select * from empleados where nrcuit = '$nrcuit'";
$result = mysql_query($sql,$db);
$nfilas = mysql_num_rows($result);
if ($nfilas < 1) {
	print ("Cantidad de empleados Registrados:  <strong>0</strong>");
} else {
	print ("Cantidad de empleados Registrados:  <strong>".$nfilas."</strong>");
}

print ("<br>");

$sql = "select * from empleados where nrcuit = '$nrcuit' and activo = 'SI'";
$result = mysql_query($sql,$db);
$nfilas = mysql_num_rows($result);
if ($nfilas < 1) {
	print ("Cantidad de empleados Activos: <strong>0</strong>");
} else {
	print ("Cantidad de empleados Activos: <strong>".$nfilas."</strong>");
}
?>

<table width="100%" border="1" bordercolor="#FFFFFF" bgcolor="#CC9933">
  <tr> 
    <td><div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">RECUERDE 
        QUE LAS REMUNERACIONES SE INGRESAN UTILIZANDO PUNTO (.) COMO SEPARADOR 
        DECIMAL.</font></strong></div></td>
  </tr>
</table>

<form name="form1" method="post" action="grabadetallesDdjj.php?filas=<?php echo $nfilas?>&nrcuit=<?php echo $nrcuit?>" onSubmit="return valida_envia();">
  <table width="1095" border="0">
    <tr>
      <td width="103" height="51"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Año</font>
	  <font size="1">
	  		<select size=1 name="anio" id="anio" onChange="ComponerLista(document.forms.form1.anio[selectedIndex].value);">
			  	<option value="-1" selected>----</option>
	  		<?php 
	  			$sqlAnios = "select * from anios order by anio DESC limit 11";
				$resAnios = mysql_query($sqlAnios,$db);
				while ($rowAnios=mysql_fetch_array($resAnios)) {
					print("<option value=".$rowAnios['anio'].">".$rowAnios['anio']."</option>");
				}
	 		 ?>	 
	    </select>
 	  </font></strong>	  </td>
     
	  <td width="297"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Periodo</font> <font size="1">
      <select name="periodos" id="periodos" onChange="CargarMonto(document.forms.form1.periodos[selectedIndex].value, <?php echo $nfilas?> );">
        <option value= "-1" selected>----</option>
      </select>
      </font></strong></td>
	  <td width=681><strong><font size="-1" face="Arial, Helvetica, sans-serif">Vale aclarar que para el<font color="#000099"> pago de los no remunerativos </font>a  partir del mes de Abril, para la columna en donde se informa la remuneraci&oacute;n  para cada CUIL deber&aacute; consignarse la remuneraci&oacute;n b&aacute;sica correspondiente al per&iacute;odo <font color="#000099">Abril 2013</font></font></strong></td>
    </tr>
  </table>
  <table border=1 width=100% bordercolorlight=#D08C35 bordercolordark=#D08C35 bordercolor=#CD8C34 cellpadding=2 cellspacing=0>
    <td width=15%><strong><font face=Verdana, Arial, Helvetica, sans-serif size=1>CUIL</font></strong></td>
    <td width=40%><strong><font face=Verdana, Arial, Helvetica, sans-serif size=1>Apellido 
      y Nombre</font></strong></td>
    <td width=15%><strong><font face=Verdana, Arial, Helvetica, sans-serif size=1>Fecha 
      de Ingreso</font></strong></td>
    <td width=30%><strong><font face=Verdana, Arial, Helvetica, sans-serif size=1>Remuneración</font></strong></td>
    </tr>
	<?php
	$i = 1;
	while ($row=mysql_fetch_array($result)) {
		print ("<tr>");
		print ("<input type=hidden name=Z".$i."size=20 value=".$row["nrcuil"].">");
		$cuil[$i-1] = $row["nrcuil"];
		$cuill01 = substr($row['nrcuil'],0,2);
		$cuill02 = substr($row['nrcuil'],2,8);
		$cuill03 = substr($row['nrcuil'],10,1);
		print ("<td width=15%><font face=Verdana size=1>".$cuill01."-".$cuill02."-".$cuill03."</font></td>");
		$totnom = sprintf("%s %s", $row["apelli"],$row["nombre"]);
		print ("<input type=hidden name=X".$i."size=20 value=\"".$totnom."\">");
		print ("<td width=35%><font face=Verdana size=1><b>".$totnom."</b></font></td>");
		$fec01 = substr($row["fecing"],0,4);
		$fec02 = substr($row["fecing"],5,2);
		$fec03 = substr($row["fecing"],8,2);
		print ("<input type=hidden name=Y".$i."size=20 value=".$row["fecing"].">");
		print ("<td width=25%><font face=Verdana size=1>".$fec03."/".$fec02."/".$fec01."</font></td>");
		print ("<td width=25%><font face=Verdana size=1><input type=text id=T".$i." name=T".$i." size=20 value=0.00></font></td>");
		print ("</tr>");
		$i++;
	}
	print ("</font></p>");
	?>
</table>

  <p><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Empleados no declarados</font></strong></p>
  <table border=1 width=100% bordercolorlight=#D08C35 bordercolordark=#D08C35 bordercolor=#CD8C34 cellpadding=2 cellspacing=0>
  <tr>
    <td width=15%><strong><font face=Verdana, Arial, Helvetica, sans-serif size=1>CUIL</font></strong></td>
    <td width=40%><strong><font face=Verdana, Arial, Helvetica, sans-serif size=1>Apellido y Nombre</font></strong></td>
    <td width=15%><strong><font face=Verdana, Arial, Helvetica, sans-serif size=1>Fecha de Ingreso</font></strong></td>
    <td width=30%><strong><font face=Verdana, Arial, Helvetica, sans-serif size=1>Motivo</font></strong></td>
  </tr>
   <?php
	$sql = "select * from empleados where nrcuit = '$nrcuit' and activo = 'NO'";
	$result = mysql_query($sql,$db);
	$mfilas = mysql_num_rows($result);
	if ($mfilas < 1) {
		print ("<font face=Verdana size=2>Cantidad de empleados Inactivos: <strong>0</strgon></font>");
	} else {
		print ("<font face=Verdana size=2>Cantidad de empleados Inactivos: <strong>".$mfilas."</strgon></font>");
	}

	print ("<input type=hidden name=P1size=20 value=".$mfilas.">");	  
	$i = 1;
	while ($row=mysql_fetch_array($result)) {
		print ("<tr>");
		print ("<input type=hidden name=h".$i."size=20 value=".$row["nrcuil"].">");
		$cuil[$i-1] = $row["nrcuil"];
		$cuill01 = substr($row['nrcuil'],0,2);
		$cuill02 = substr($row['nrcuil'],2,8);
		$cuill03 = substr($row['nrcuil'],10,1);
		print ("<td width=15%><font face=Verdana size=1>".$cuill01."-".$cuill02."-".$cuill03."</font></td>");
		$totnom = sprintf("%s %s", $row["apelli"],$row["nombre"]);
		print ("<td width=35%><font face=Verdana size=1><b>".$totnom."</b></font></td>");
		$fec01 = substr($row["fecing"],0,4);
		$fec02 = substr($row["fecing"],5,2);
		$fec03 = substr($row["fecing"],8,2);
		print ("<td width=25%><font face=Verdana size=1>".$fec03."/".$fec02."/".$fec01."</font></td>");
		print ("<td width=25%><font face=Verdana size=1><input type=text name=U".$i."size=20 ></font></td>");
		print ("</tr>");
		$i++;
	}
	?>
  </table>

  <p><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">
    <input type="submit" value="Ingresar Datos" name="B1" style="background-color: #E4C192; border-style: solid; border-color: #D28E37">
    
    </font></strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font> 
    
  </p>
</form>

<a href="listaddjjAnteriores.php" ><font color="#CD8C34" face="Verdana" size="2"><b>Volver</b></font></a> 

</html>

