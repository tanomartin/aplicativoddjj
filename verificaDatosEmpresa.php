<html>

<head>

<title>.: U.S.I.M.R.A. :.</title>
<style>
<!--
A:link {text-decoration: none}
A:visited {text-decoration: none}
A:hover {text-decoration:underline; color:FCF63C}
-->
</style>

<STYLE>BODY {SCROLLBAR-FACE-COLOR: #E4C192; 
SCROLLBAR-HIGHLIGHT-COLOR: #CD8C34; 
SCROLLBAR-SHADOW-COLOR: #CD8C34; 
SCROLLBAR-3DLIGHT-COLOR: #CD8C34; 
SCROLLBAR-ARROW-COLOR: #CD8C34; 
SCROLLBAR-TRACK-COLOR: #CD8C34; 
SCROLLBAR-DARKSHADOW-COLOR: #CD8C34
}
</STYLE>
</head>

<body bgcolor="#E4C192" link="#000000">
<p align="center"><img border="0" src="img/top.jpg" width="700" height="120"></p>

<p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">

<div align="center">
  <table align="center" border=0 cellpadding="5">
    <?php
$datos = array_values($_POST);
$cuit01 = $datos [0];
$cuit02 = $datos [1];
$cuit03 = $datos [2];
$nrcuit = $cuit01.$cuit02.$cuit03;
$nombr = $datos [3];
$nombre = strtoupper($nombr);
$domil = $datos [4];
$domile = strtoupper($domil);
$local = $datos [5];
$locali = strtoupper($local);
$provin = $datos [6];
$copol = $datos [7];
$copole = strtoupper($copol);
$telfon01 = $datos [8];
$telfon02 = $datos [9];
$telfon03 = $datos [10];
$telfon = $telfon01.$telfon02.$telfon03;
$emails = $datos [11];
$activi = $datos [12];
$fecini01 = $datos [13];
$fecini02 = $datos [14];
$fecini03 = $datos [15];
$fecini = $fecini03.$fecini02.$fecini01;
$rramaa = $datos [16];
$claveacc = $datos [17];

require ("lib/verificaCuit.php");

$pepe = validacuit($nrcuit);
if ($pepe == 0){
	print("<p align='center' style='word-spacing: 0; margin-top: 0; margin-bottom: 0'><strong><font color='#FF0000' size='2' face='Arial, Helvetica, sans-serif'>NÚMERO DE CUIT INVÁLIDO</font></strong></p>");
}
else {
	include("lib/conexion.php");
	//Ejecucion de la sentencia SQL

	$sql = "select * from empresa where nrcuit = $nrcuit";
	$result = mysql_query($sql,$db);
	$nocuit = mysql_num_rows($result);

	if ($nocuit > 0) {
		print ("Cuit existente");
	}
	else {
$provincia = array ("PROVINCIA", "CAPITAL FEDERAL", "BUENOS AIRES", "MENDOZA", "NEUQUEN", "SALTA", "ENTRE RIOS", "MISIONES", "CHACO", "SANTA FE", "CORDOBA", "SAN JUAN", "RIO NEGRO", "CORRIENTES", "SANTA CRUZ", "CHUBUT", "FORMOSA", "LA PAMPA", "SANTIAGO DEL ESTERO", "JUJUY", "TUCUMAN", "TIERRA DEL FUEGO", "SAN LUIS", "LA RIOJA", "CATAMARCA");
$rama = array ("RAMA", "Aglomerados", "Maderas Terciadas", "Aserraderos, Envases y Afines", "Muebles, Aberturas, Carpinterías y Demás Manufacturas de Madera y Afines", "Corcho", "Otros");

print ("
<div align=center><center>
  <table border=1 width=600  cellspacing=0 cellpadding=2 bordercolor=#DEAA63>
    <tr>
      <td width=600 colspan=2 bgcolor=#663300>
        <p align=right style=word-spacing: 0; margin-top: 0; margin-bottom: 0><font color=#FFFFFF><font face=Verdana size=2><b>DATOS DE EMPRESA</b></p></font></td>
    </tr>

    <tr>
      <td width=165><font face=Verdana size=1><b>Número CUIT:</b></font></td><td width=435><font face=Verdana size=1>".$cuit01."-".$cuit02."-".$cuit03."</font></td>
    </tr>
    <tr>
      <td width=165><font face=Verdana size=1><b>Nombre o Razón Social:</b></font></td><td width=435><font face=Verdana size=1>".$nombre."</font></td>
    </tr>
    <tr>
      <td width=165><font face=Verdana size=1><b>Domicilio:</b></font></td><td width=435><font face=Verdana size=1>".$domile."</font></td>
    </tr>
    <tr>
      <td width=165><font face=Verdana size=1><b>Localidad:</b></font></td><td width=435><font face=Verdana size=1>".$locali."</font></td>
    </tr>
    <tr>
      <td width=165><font face=Verdana size=1><b>Provincia:</b></font></td><td width=435><font face=Verdana size=1>".$provincia[$provin]."</font></td>
    </tr>
    <tr>
      <td width=165><font face=Verdana size=1><b>Código Postal:</b></font></td><td width=435><font face=Verdana size=1>".$copole."</font></td>
    </tr>
    <tr>
      <td width=165><font face=Verdana size=1><b>Teléfono:</b></font></td><td width=435><font face=Verdana size=1>(".$telfon01.") ".$telfon02."-".$telfon03."</font></td>
    </tr>
    <tr>
      <td width=165><font face=Verdana size=1><b>Email:</b></font></td><td width=435><font face=Verdana size=1>".$emails."</font></td>
    </tr>
    <tr>
      <td width=165><font face=Verdana size=1><b>Actividad:</b></font></td><td width=435><font face=Verdana size=1>".$activi."</font></td>
    </tr>
    <tr>
      <td width=165><font face=Verdana size=1><b>Fecha de Inicio:</b></font></td><td width=435><font face=Verdana size=1>".$fecini01."/".$fecini02."/".$fecini03."</font></td>
    </tr>
	 <tr>
     <td width=165><font face=Verdana size=1><b>Rama:</b></font></td><td width=435><font face=Verdana size=1>".$rama[$rramaa]."</font></td>
    </tr>
    <tr>
      <td width=165><font face=Verdana size=1><b>Contraseña:</b></font></td><td width=435><font face=Verdana size=1>".$claveacc."</font></td>
    </tr>
    <tr>
      <td width=600 colspan=2 bgcolor=#DEAA63>&nbsp;</td>
    </tr>
    </table>
  </center>
</div>
");

print ("<br>");
print ("<form method=POST action=grabaEmpresa.php>");
print ("<input type=hidden name=a1 size=20 value=".$nrcuit.">");
print ("<input type=hidden name=a2 size=20 value=\"".$nombre."\">");
print ("<input type=hidden name=a3 size=20 value=\"".$domile."\">");
print ("<input type=hidden name=a4 size=20 value=\"".$locali."\">");
print ("<input type=hidden name=a5 size=20 value=".$provin.">");
print ("<input type=hidden name=a6 size=20 value=".$copole.">");
print ("<input type=hidden name=a7 size=20 value=".$telfon.">");
print ("<input type=hidden name=a8 size=20 value=".$emails.">");
print ("<input type=hidden name=a9 size=20 value=\"".$activi."\">");
print ("<input type=hidden name=a10 size=20 value=".$fecini.">");
print ("<input type=hidden name=a11 size=20 value=".$rramaa.">");
print ("<input type=hidden name=a12 size=20 value=".$claveacc.">");

?>
    <p>  
    <div align="center">
      <input type="submit" value="Ingresar Empresa" name="B1" style="background-color: #E4C192; border-style: solid; border-color: #D28E37">
    </div>
    <p></p>
    <?php
print ("</form>");
}
}
?>
  </table>
</div>
</p>
<div align="center"><a href="#" onClick="history.go(-1)"><font color="#CD8C34" face="Verdana" size="2"><b>Volver</b></font></a> 
</div>
</body>


</html>