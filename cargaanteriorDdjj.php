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
		$result3 = mysql_db_query("uv0472_aplicativo",$sql3,$db);
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
		$result = mysql_db_query("uv0472_aplicativo",$sql,$db);
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
  <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
  <p> 

<?php
$sql = "select * from empleados where nrcuit = '$nrcuit'";
$result = mysql_db_query("uv0472_aplicativo",$sql,$db);
$nfilas = mysql_num_rows($result);

if ($nfilas < 1) {
	print ("Cantidad de empleados Registrados: 0");
} else {
	print ("Cantidad de empleados Registrados: ".$nfilas);
}

print ("<br>");

$sql = "select * from ppjj where nrcuit = '$nrcuit' and nrctrl = '$nrctrlold'";
$result = mysql_db_query("uv0472_aplicativo",$sql,$db);
$nfilas = mysql_num_rows($result);
while ($row=mysql_fetch_array($result)) {
	//$cant = 0:
	$culcito = $row["nrcuil"];
	$sql2 = "select * from empleados where nrcuit = '$nrcuit' and nrcuil = '$culcito'";
	$ress = mysql_db_query("uv0472_aplicativo",$sql2,$db);
	$cantidad = mysql_num_rows($ress);
	if ($cantidad < 1) {
    	echo 'UNO O MAS REGISTROS HAN SIDO ELIMINADOS CON ANTERIORIDAD';
		echo '<br>';
		$huevo = 1;
?>
	<a href="#" onClick="history.go(-1)"><font color="#CD8C34" face="Verdana" size="2"><b>Volver</b></font></a> 				
<?php
	break;
	} 
}

if ($huevo != 1) {
	$sql = "select * from ppjj where nrcuit = '$nrcuit' and nrctrl = '$nrctrlold'";
	$result = mysql_db_query("uv0472_aplicativo",$sql,$db);
	$nfilas = mysql_num_rows($result);
?>

<table width="100%" border="1" bordercolor="#FFFFFF" bgcolor="#CC9933">
  <tr>
    <td><div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">RECUERDE 
        QUE LAS REMUNERACIONES SE INGRESAN UTILIZANDO PUNTO (.) COMO SEPARADOR 
        DECIMAL.</font></strong></div>
	</td>
  </tr>
</table>

<p>
<form name="form1" method="post" action="grabadetallesDdjj.php?filas=<? echo $nfilas?>&nrcuit=<? echo $nrcuit?>" onSubmit="return valida_envia();">
  <table width="466" border="0">
    <tr>
      <td width="145" height="51"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Año</font>
	  <font size="1">
	  		<select size=1 name="anio" id="anio" onChange="ComponerLista(document.forms.form1.anio[selectedIndex].value);">
			  	<option value="-1" selected>----</option>
	  		<?php 
	  			$sqlAnios = "select * from anios order by anio DESC limit 11";
				$resAnios = mysql_db_query("uv0472_aplicativo",$sqlAnios,$db);
				while ($rowAnios=mysql_fetch_array($resAnios)) {
					print("<option value=".$rowAnios['anio'].">".$rowAnios['anio']."</option>");
				}
	 		 ?>	 
	    </select>
 	  </font></strong>
	  </td>
     
	  <td width="311"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Periodo</font>
	  <font size="1">
			<select name="periodos" id="periodos" onChange="CargarMonto(document.forms.form1.periodos[selectedIndex].value, <?php echo $nfilas?> );">
				<option value= "-1" selected>----</option>
			</select>
      </font></strong>	  
	  </td>
    </tr>
  </table>
<br>
<table border=1 width=100% bordercolorlight=#D08C35 bordercolordark=#D08C35 bordercolor=#CD8C34 cellpadding=2 cellspacing=0>
	<td width=15%><font face=Verdana size=1><b>CUIL</b></font></td>
	<td width=40%><font face=Verdana size=1><b>Apellido y Nombre</b></font></td>
	<td width=15%><font face=Verdana size=1><b>Fecha de Ingreso</b></font></td>
	<td width=30%><font face=Verdana size=1><b>Remuneración</b></font></td>
</tr>	  
<?php	  
$i = 1;
while ($row=mysql_fetch_array($result)) {
	print ("<tr>");
	print ("<input type=hidden name=Z".$i."size=20 value=".$row["nrcuil"].">");
	$cuil[$i-1] = $row["nrcuil"];
	// cuilcito es para no poner el puto row dentro de la consulta sql,,,esto lo pongo porque los programadores hacemos acotaciones y decimos bibliotecas en vez de librerias
	$culcito = $row["nrcuil"];
	$cuill01 = substr($row['nrcuil'],0,2);
	$cuill02 = substr($row['nrcuil'],2,8);
	$cuill03 = substr($row['nrcuil'],10,1);
	print ("<td width=15%><font face=Verdana size=1>".$cuill01."-".$cuill02."-".$cuill03."</font></td>");
	$sql = "select * from empleados where nrcuit = '$nrcuit' and nrcuil = '$culcito'";
	$res = mysql_db_query("uv0472_aplicativo",$sql,$db);
	$graciela=mysql_fetch_array($res);
	$totnom = sprintf("%s %s", $graciela["apelli"],$graciela["nombre"]);
	print ("<input type=hidden name=X".$i."size=20 value=\"".$totnom."\">");
	print ("<td width=35%><font face=Verdana size=1><b>".$totnom."</b></font></td>");
	$fec01 = substr($graciela["fecing"],0,4);
	$fec02 = substr($graciela["fecing"],5,2);
	$fec03 = substr($graciela["fecing"],8,2);
	print ("<input type=hidden name=Y".$i."size=20 value=".$graciela["fecing"].">");
	print ("<td width=25%><font face=Verdana size=1>".$fec03."/".$fec02."/".$fec01."</font></td>");
	print ("<td width=25%><font face=Verdana size=1><input type=text id=T".$i." name=T".$i."size=20 value=".$row['remune']."></font></td>");
	print ("</tr>");
	$i++;
}
print ("</font></p>");
?>
</table>
<input type="submit" value="Ingresar Datos" name="B1" style="background-color: #E4C192; border-style: solid; border-color: #D28E37">
</form>

<p>&nbsp; 
<a href="listaddjjAnteriores.php" ><font color="#CD8C34" face="Verdana" size="2"><b>Volver</b></font></a> 
<?php
//parentesis del if del huevo
}
?>
</html>